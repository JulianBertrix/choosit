//permet d'ajouter un produit au panier
window.addProductToCart = function(id) {
    //on ajoute un produit au panier seulement si une quantité a été séléctionnée
    if ($("#qte").val() !== "") {
        $.ajax({
            url: window.location.origin + "/add/product/" + id,
            type: "POST",
            data: {
                qte: $("#qte").val()
            },
            success: function(data) {
                alert("votre produit à bien été ajouté au panier");
                document.location.reload();
            },
            error: function() {
                alert("erreur");
            }
        });
    } else {
        alert("Une erreur est survenue, merci de réessayer ou de selectionner une quantité!");
    }
};

//permet de vider le panier
window.clearCart = function() {
    $.ajax({
        url: window.location.origin + "/clear/cart",
        type: "POST",

        success: function() {
            alert("votre panier à bien été vidé");
            document.location.href = window.location.origin;
        },
        error: function() {
            alert("erreur");
        }
    });
};

//permet de supprimer un produit du panier
window.deleteCartProd = function(id) {
    $.ajax({
        url: window.location.origin + "/delete/cart/prod/" + id,
        type: "POST",

        success: function() {
            alert("le produit à bien été retirer de votre panier");
            document.location.href = window.location.origin;
        },
        error: function() {
            alert("erreur");
        }
    });
};

//permet d'afficher le nombre de produit dans le panier
$(document).ready(function() {
    $.ajax({
        url: window.location.origin + "/get/cart",
        type: "GET",

        success: function(data) {
            //on affiche le nombre de produit si il y en a dans le panier 
            //sinon on affiche 0
            if (data !== null) {
                $(".badge").text(data.length);
            } else {
                $(".badge").text(0);
            }
        },
    });
});

//permet de retirer une unité à la quantité un produit du panier
window.subProdQte = function(id) {
    $.ajax({
        url: window.location.origin + "/sub/quantity/prod/" + id,
        type: "POST",

        success: function(data) {
            document.location.reload();
        },
        error: function() {
            alert("erreur");
        }
    });
};

//permet d'ajouter une unité à la quantité un produit du panier
window.addProdQte = function(id) {
    $.ajax({
        url: window.location.origin + "/add/quantity/prod/" + id,
        type: "POST",

        success: function(data) {
            document.location.reload();
        },
        error: function() {
            alert("erreur");
        }
    });
};