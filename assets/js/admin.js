//permet de créer un nouveau produit
window.createProduct = function() {
    //on verifie si les champs sont remplit avant de la création d'un nouveau produit
    if ($("#nomProduit").val() !== "" && $("#descriptionProduit").val() !== "" && $("#prixProduit").val() !== "") {
        $.ajax({
            url: window.location.origin + "/create/prod",
            type: "POST",
            data: {
                'nom': $("#nomProduit").val(),
                'description': $("#descriptionProduit").val(),
                'prix': $("#prixProduit").val()
            },

            success: function() {
                alert("le produit à bien été ajouter");
                document.location.reload();
            },
            error: function() {
                alert("erreur");
            }
        });
    } else {
        alert("Merci de remplire tous les champs");
    }
};

//permet de modifier un produit
window.updateProduct = function(id) {
    $.ajax({
        url: window.location.origin + "/update/prod/" + id,
        type: "POST",
        data: {
            'nom': $("#nom" + id).val(),
            'description': $("#description" + id).val(),
            'prix': $("#prix" + id).val()
        },

        success: function() {
            alert("le produit à bien été mis à jour");
            document.location.reload();
        },
        error: function() {
            alert("erreur");
        }
    });
};

//permet de supprimer un produit
window.deleteProduct = function(id) {
    $.ajax({
        url: window.location.origin + "/delete/prod/" + id,
        type: "POST",

        success: function() {
            alert("le produit à bien été supprimer");
            document.location.reload();
        },
        error: function() {
            alert("erreur");
        }
    });
};