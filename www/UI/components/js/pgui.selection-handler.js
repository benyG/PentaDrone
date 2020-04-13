define([
    'class',
    'pgui.localizer',
    'pgui.utils',
    'libs/sprintf',
    'pgui.form_collection',
    'pgui.modal_operation_link',
    'underscore',
    'jquery.query',
    'bootbox'
], function (Class, localizer, utils, sprintf, FormCollection, modalLink) {

    function buildForm(url, data) {
        var $form = $('<form>').hide()
            .attr('method', 'POST')
            .attr('action', url);

        _.each(data, function (value, name) {
            $form.append($('<input name="' + name + '" value="' + value + '">'));
        });

        return $form.appendTo($('body'));
    }

    return Class.extend({
        init: function (selection, $container, $allCheckbox, $checkboxes, hideContainer, grid) {
            this.hideContainer = hideContainer;
            this.$container = $container || $('.js-selection-actions-container').first();
            this.$actions = $container.find('.js-action');
            this.$count = $container.find('.js-count');
            this.selection = selection;
            this.grid = grid;
            this.setCheckboxes($allCheckbox || $(), $checkboxes || $());

            this.$actions.on('click', this._handleAction.bind(this));
            this.selection.bind('change', this._handleChange.bind(this));
            this._handleChange(this.selection.getData());
        },

        setCheckboxes: function ($allCheckbox, $checkboxes) {
            this.$allCheckbox = $allCheckbox || $();
            this.$checkboxes = $checkboxes || $();

            this.checkboxesData = _.map(this.$checkboxes, function (v, k) {
                return $(v).data('value');
            });

            this.$checkboxes.off('change').on('change', this._checkboxChangeHandler.bind(this));
            this.$allCheckbox.off('change').on('change', this._allCheckboxChangeHandler.bind(this));
        },

        _checkboxChangeHandler: function (e) {
            var $el = $(e.currentTarget);
            this.selection.toggle($el.data('value'), $el.prop('checked'));
        },

        _allCheckboxChangeHandler: function (e) {
            var checked = $(e.currentTarget).prop('checked')
            this.$checkboxes.prop('checked', checked);

            _.each(this.checkboxesData, function (value) {
                if (checked) {
                    this.selection.add(value);
                } else {
                    this.selection.remove(value);
                }
            }.bind(this));
        },

        _handleChange: function (selectionData) {
            var count = selectionData.length;

            if (this.hideContainer) {
                this.$container.toggle(count > 0);
                _.defer(this.$container.toggleClass.bind(this.$container), 'in', count > 0);
            }

            this.$count.text(count);
            this.$checkboxes.prop('checked', false);

            _.each(selectionData, function (keys) {
                this.$checkboxes
                    .filter("[data-value='" + JSON.stringify(keys) + "']")
                    .prop('checked', true);
            }.bind(this));

            var checkedCount = this.$checkboxes.filter(':checked').length;
            this.$allCheckbox
                .prop('checked', checkedCount === this.$checkboxes.length && this.$checkboxes.length > 0)
                .prop('indeterminate', checkedCount > 0 && checkedCount < this.$checkboxes.length);
        },

        _handleAction: function (e) {
            var $el = $(e.currentTarget);
            var type = $el.data('type');
            e.preventDefault();

            switch (type) {
                case 'compare':
                    return this._compare($el.data('url'));
                case 'compare-remove':
                    return this._compareRemove($el.attr('href'), $el.data('value'));
                case 'print':
                    return this._print($el.data('url'));
                case 'export':
                    return this._export($el.data('url'), $el.data('export-type'));
                case 'update':
                    return this._update($el);
                case 'delete':
                    return this._delete($el.data('url'));
                case 'clear':
                    return this.selection.clear();
            }
        },

        _delete: function (url) {
            var self = this;

            bootbox.confirm(localizer.getString('DeleteSelectedRecordsQuestion'), function(confirmed) {
                if (confirmed) {

                    utils.createLoadingModalDialog(localizer.getString('Deleting')).modal();

                    var selectionData = self.selection.getData();
                    var formData = {
                        operation: 'delsel',
                        recordCount: selectionData.length,
                    };

                    _.each(selectionData, function (keys, i) {
                        formData['rec' + i] = null;

                        _.each(keys, function (value, pk) {
                            formData['rec' + i + '_pk' + pk] = value;
                        });

                        self.selection.remove(keys);
                    });

                    buildForm(url, formData).submit();
                }
            });
        },

        _compare: function (url) {
            this._processSelectedRecords(url, 'compare');
        },

        _compareRemove: function (url, value) {
            this.selection.remove(value);
            location.href = url;
        },

        _print: function (url) {
            this._processSelectedRecords(url, 'print_selected');
        },

        _export: function (url, exportType) {
            this._processSelectedRecords(url, sprintf.sprintf('e%s_selected', exportType));
        },

        _update: function ($el) {
            var self = this;
            if ($el.data('modal-operation') === 'multiple-edit') {
                var handlerName = $el.data('multiple-edit-handler-name');
                var url = jQuery.query.load($el.data('url'))
                    .set('hname', handlerName)
                    .set('keys', this.selection.getData())
                    .toString();
                $el.data('content-link', url);
                modalLink.processQuery(FormCollection, $el, function ($modal, hasErrors, responses, params) {
                    var $grid = $el.closest('.js-grid');
                    var $row = $();
                    if (!hasErrors) {
                        $.each(responses[0].row, function (i, row) {
                            $row = $(row);
                            $grid.find(".row-selection input").each(function() {
                                if ($(this).attr('data-value') === responses[0].primaryKeys[i]) {
                                    $(this).closest('.pg-row').replaceWith($row);
                                    self.grid.integrateRows($row);
                                    return false;
                                }
                            });
                        });
                        $modal.modal('hide');
                        self.selection.clear();
                    }
                    return hasErrors;
                });
            } else {
                this._processSelectedRecords($el.data('url'), 'multi_edit');
            }
        },

        _processSelectedRecords: function (url, operation) {
            location.href = jQuery.query.load(url)
                .set('operation', operation)
                .set('keys', this.selection.getData())
                .toString();
        }

    });
});
