<script>
    function adjustHeightOfWidgetContainer() {
        if ($('.js-widget-container').height() > $(window).height() - 175) {
            $('.js-widget-container').height($(window).height() - 170).addClass("overflow-y-scroll");
        }
    }
    function addNewColumn(columnValue) {
        var newColumnDiv = "",
                columns = columnValue.split("-");

        for (var i = 0; i < columns.length; i++) {
            newColumnDiv = newColumnDiv + "<div class='pr0 pl15 widget-column col-md-" + columns[i] + " col-sm-" + columns[i] + "'><div id='add-column-panel-" + getRandomAlphabet(5) + "' class='add-column-panel add-column-drop text-center p15'><span class='text-off empty-area-text'><?php echo app_lang('drag_and_drop_widgets_here'); ?></span></div></div>";
        }

        $("#widget-column-container").append("<row class='widget-row clearfix d-flex bg-white' data-column-ratio='" + columnValue + "'><div class='float-start row-controller text-off font-16'><span class='move'><i data-feather='menu' class='icon-16'></i></span><span class='delete delete-widget-row'><i data-feather='x' class='icon-16'></i></span></div><div class='float-start clearfix row-container row pr15 pl15'>" + newColumnDiv + "</div></row>");
        $("#add-column-button").trigger("click");
        
        feather.replace();

        setTimeout(function () {
            initSortable();
        }, 500);

    }
    function initSortable() {
        var options = {
            animation: 150,
            chosenClass: "sortable-chosen",
            ghostClass: "sortable-ghost",
            filter: ".empty-area-text",
            cancel: ".empty-area-text",
            onAdd: function (e) {
                saveWidgetPosition();

                removeEmptyAreaText(e.to);
                addEmptyAreaText(e.to);
                addEmptyAreaText(e.from);
            },
            onUpdate: function (e) {
                saveWidgetPosition();
                removeEmptyAreaText(e.to);
                addEmptyAreaText(e.to);
                addEmptyAreaText(e.from);
            }
        };
        $(".add-column-panel").each(function (index) {

            var id = this.id;
            options.group = "add-column-panel";
            Sortable.create($("#" + id)[0], options);
        });
        options.group = "widget-column-container";
        Sortable.create($("#widget-column-container")[0], options);
    }
    function removeEmptyAreaText(index) {
        if ($(index).has("div").length > 0 && $(index).attr("id") !== "widget-column-container") {
            $(index).find("span.empty-area-text").remove();
        }
    }
    function addEmptyAreaText(index) {
        if ($(index).has("div").length < 1) {
            if ($(index).hasClass("js-widget-container")) {
                $(index).html("<span class='text-off empty-area-text'><?php echo app_lang('no_more_widgets_available'); ?></span>");
            } else {
                $(index).html("<span class='text-off empty-area-text'><?php echo app_lang('drag_and_drop_widgets_here'); ?></span>");
            }
        }
    }
    function saveWidgetPosition() {
        var rows = [];

        $(".widget-row").each(function (index) {
            var columns = [],
                    $widgetColumn = $(this).find(".widget-column"),
                    columnRatio = $(this).attr("data-column-ratio");

            if ($widgetColumn) {
                $widgetColumn.each(function (index) {
                    var widget = $(this).find(".widget").attr("data-value");

                    if (widget) {
                        var widgets = [];
                        $(this).find(".widget").each(function (index) {
                            var widgetValue = $(this).attr("data-value");

                            if (widgetValue) {
                                widgets.push({widget: widgetValue, title: $(this).find(".float-start").text()});
                            }
                        });

                        columns.push(widgets);
                    }
                });
            }

            if (columns.length) {
                rows.push({columns: columns, ratio: columnRatio});
            }
        });

        //convert array to json data and save into an input field
        $("#widgets-data").val(JSON.stringify(rows));
    }
</script>