var BlogCategories = function (context) {
    var self = this;

    this.onSaveClick = function () {
        context.submit({
            form: '#form-category',
            method: 'save',

            onSuccess: function () {

                if ($('[name=uid]').val() === "") {
                    var activityName = "BlogCategories";
                    window.location = "/" + context.getAliasFromURI() + routing[activityName].default.base;
                } else {
                    context.throwMessage('success', "Wijzigingen met succes opgeslagen");
                }
            }
        });
    };

    this.onDeleteClick = function (event) {
        try {
            event.preventDefault();

            app.modals.confirm({
                modalTitle: "Verwijderen",
                modalText: "De geselecteerde product(en) worden verwijderd. Weet je het zeker?",

                modalConfirmAction: function () {
                    var selected = app.table.getSelectedValues('#table-products');

                    context.call({
                        method: 'delete',
                        params: {
                            uids: selected
                        },
                        onSuccess: function (r, m) {
                            context.throwMessage('success', m);
                            app.table.removeSelectedRows('#table-products');
                        }
                    });
                }
            });
        } catch (e) {
            context.report(e);
        }
    };

    this.onRemoveImageClick = function (event) {
        try {
            event.preventDefault();

            $('#upload-image').prop('src', '/peanuts/res/assets/dist/img/image-placeholder.jpg');
            $('[name=image]').val('delete');
        } catch (e) {
            context.report(e);
        }
    };

    this.activate = function (event) {
        event.preventDefault();
        var sel = app.table.getSelectedValues("#table-products");

        if (sel.length > 0) {

            context.call({
                method: 'activate',
                params: {
                    uids: sel
                },
                onSuccess: function (res) {
                    context.throwMessage("success", "Items met success geactiveerd.");
                    app.table.reload('#table-products');
                    $('#checkbox-all').prop('checked', false);
                },
                onError: function () { }
            });

        }
    };

    this.deactivate = function (event) {
        event.preventDefault();
        var sel = app.table.getSelectedValues("#table-products");

        if (sel.length > 0) {

            context.call({
                method: 'deactivate',
                params: {
                    uids: sel
                },
                onSuccess: function (res) {
                    context.throwMessage("success", "Items met success gedeactiveerd.");
                    app.table.reload('#table-products');
                    $('#checkbox-all').prop('checked', false);
                },
                onError: function () { }
            });

        }
    };

	/**
     * Initialize
	 */
    this.init = function () {

    };
};