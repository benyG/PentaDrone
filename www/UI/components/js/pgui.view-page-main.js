define([
    'pgui.utils',
    'pgui.field-embedded-video',
    'pgui.cell-edit',
    'pgui.selection',
    'pgui.selection-handler',
    'pgui.image_popup'
], function(utils, showFieldEmbeddedVideo, initCellEdit, Selection, SelectionHandler, initImagePopup) {

    return function () {
        var $body = $('body');

        utils.updatePopupHints($body);
        showFieldEmbeddedVideo($body);
        initImagePopup($body);


        $body.find('[data-edit-url]').each(function (i, el) {
            var $el = $(el)
            var columnName = $el.data('column-name');
            initCellEdit($el, function (response) {
                $el.html(response.columns[columnName]);
                $body.find('.js-message-container').append(
                    utils.buildDismissableMessage(
                        'success',
                        response.message,
                        response.messageDisplayTime
                    )
                );
            });
        });

        var $selectionActions = $body.find('.js-selection-actions-container');
        if ($selectionActions.length) {
            var selectionHandler = new SelectionHandler(
                new Selection($selectionActions.data('selection-id')),
                $selectionActions
            );
        }
    }

});
