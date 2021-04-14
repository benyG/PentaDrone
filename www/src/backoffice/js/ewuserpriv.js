loadjs.ready("makerjs", function() {
    var $ = jQuery;

    function getDisplayFn(name, trueValue) {
        return function(data) {
            var row = data.record, id = name + '_' + row.index,
                checked = (row.permission & trueValue) == trueValue;
            row.checked = checked;
            return '<div class="custom-control custom-checkbox d-inline-block"><input type="checkbox" class="custom-control-input ew-priv ew-multi-select" name="' + id + '" id="' + id +
                '" value="' + trueValue + '" data-index="' + row.index + '"' +
                (checked ? ' checked' : '') +
                (((row.allowed & trueValue) != trueValue) ? ' disabled' : '') + '><label class="custom-control-label" for="' + id + '"></label></div>';
        };
    }

    function displayTableName(data) {
        var row = data.record;
        return row.table + '<input type="hidden" name="table_' + row.index + '" value="1">';
    }

    function getRecords(data, params) {
        var rows = priv.permissions.slice(0);
        if (data && data.table) {
            var table = data.table.toLowerCase();
            rows = $.map(rows, function(row) {
                if (row.table.toLowerCase().includes(table))
                    return row;
                return null;
            });
        }
        if (params && params.sorting) {
            var asc = params.sorting.match(/ASC$/);
            rows.sort(function(a, b) { // Case-insensitive
                if (b.table.toLowerCase() > a.table.toLowerCase())
                    return (asc) ? -1 : 1;
                else if (b.table.toLowerCase() === a.table.toLowerCase())
                    return 0
                else if (b.table.toLowerCase() < a.table.toLowerCase())
                    return (asc) ? 1 : -1;
            });
        }
        return {
            result: "OK",
            params: Object.assign({}, data, params),
            records: rows
        };
    }

    function getTitleHtml(id, phraseId) {
        return '<div class="custom-control custom-checkbox"><input type="checkbox" class="custom-control-input ew-priv" name="' + id + '" id="' + id + '" onclick="ew.selectAll(this);">' +
            '<label class="custom-control-label" for="' + id + '">' + ew.language.phrase("Permission" + (phraseId || id)) + '</label></div>'
    }

    // Fields
    var _fields = {
        table: {
            title: '<span class="font-weight-normal">' + ew.language.phrase("TableOrView") + '</span>',
            display: displayTableName,
            sorting: true
        }
    };
    ["add", "delete", "edit", "list", "lookup", "view", "search", "import", "admin"].forEach(function(id) {
        _fields[id] = {
            title: getTitleHtml(id),
            display: getDisplayFn(id, priv[id]),
            sorting: false
        };
    });

    // Init
    $(".ew-card.ew-user-priv .ew-card-body").ewjtable({
        paging: false,
        sorting: true,
        defaultSorting: "table ASC",
        fields: _fields,
        actions: { listAction: getRecords },
        rowInserted: function(event, data) {
            var $row = data.row;
            $row.find("input[type=checkbox]").on("click", function() {
                var $this = $(this), index = parseInt($this.data("index"), 10), value = parseInt($this.data("value"), 10);
                if (this.checked)
                    priv.permissions[index].permission = priv.permissions[index].permission | value;
                else
                    priv.permissions[index].permission = priv.permissions[index].permission ^ value;
            });
        },
        recordsLoaded: function(event, data) {
            var sorting = data.serverResponse.params.sorting,
                $mc = $(this).find(".ewjtable-main-container"),
                $t = $mc.find(".ewjtable.table"),
                $c = $t.find(".ewjtable-column-header-container:first");
            if (useFixedHeaderTable) {
                if (tableHeight)
                    $mc.height(tableHeight);
                $t.addClass("table-head-fixed ew-fixed-header-table");
                if (ew.USE_OVERLAY_SCROLLBARS)
                    $mc.overlayScrollbars(ew.overlayScrollbarsOptions);
            }
            if (!$c.find(".ew-table-header-sort")[0])
                $c.append('<span class="ew-table-header-sort"><i class="fas fa-sort-down"></i></span>');
            $c.find(".ew-table-header-sort i.fas").toggleClass("fa-sort-up", !!sorting.match(/ASC$/)).toggleClass("fa-sort-down", !!sorting.match(/DESC$/));
            ew.initMultiSelectCheckboxes();
            ew.fixLayoutHeight();
        }
    });

    // Re-load records on search
    var _timer;
    $("#table-name").on("keydown keypress cut paste", function(e) {
        if (_timer)
            _timer.cancel();
        _timer = $.later(200, null, function() {
            $(".ew-card.ew-user-priv .ew-card-body").ewjtable("load", {
                table: $("#table-name").val()
            });
        });
    });

    // Load all records
    $("#table-name").keydown();
});
