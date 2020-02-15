jQuery(document).ready(function () {

    // REPLACE
    String.prototype.replaceArray = function (find, replace) {
        var replaceString = this;
        var regex;
        for (var i = 0; i < find.length; i++) {
            regex = new RegExp(find[i], "g");
            replaceString = replaceString.replace(regex, replace[i]);
        }
        return replaceString;
    };

    function refresh() {
        jQuery("#get_code").trigger('click');
    }

    function order(type) {

        jQuery('[id^=' + type + '-container-]').each(function (index, element) {
            jQuery(this).attr('id', type + '-container-' + index);
            jQuery(this).children('label').children('span').text(index);
            jQuery(this).children('label').children('input').attr('id', type + '-' + index);
            jQuery(this).children('select').attr('id', type + '-unit-' + index);
            jQuery(this).children('span').attr('id', 'del-' + type + '-' + index);
        });
    }

    function order_item() {
        //var i = 0;
        jQuery('#grid_layout .item').each(function (index, element) {
            //i = index +1;
            //console.log(jQuery(this).attr('id'));
            jQuery(this).attr('id', 'item-' + index);
            jQuery(this).children('label').text(index);
            jQuery(this).children('label').attr('class', 'item-number-' + index);
            jQuery(this).children('span').attr('id', 'del-item-' + index);
            //jQuery(this).children('input').value(index);
            jQuery(this).children('input').attr('id', 'item-name-' + index);
        });
        //jQuery('#add_item').val('Add item (' + i + ')');
    }


    // ADD COLUMN
    var col_id = 0;
    jQuery("#add_col").click(function () {
        //var len = jQuery('[id^=col-container-]').length;
        //col_id = len;
        col_id++;
        jQuery("#form #col").append(
            '<div id="col-container-' + col_id + '">' +
            '<label>Column <span>' + col_id + '</span>' +
            ' <input id="col-' + col_id + '" class="col control" value="1" type="number" min="0" /></label>' +
            ' <select id="col-unit-' + col_id + '" class="control">' +
            '<option>fr</option>' +
            '<option>%</option>' +
            '<option>px</option>' +
            '<option>em</option>' +
            '<option>rem</option>' +
            '<option>auto</option>' +
            '</select>' +
            '<span id="del-col-' + col_id + '" class="del">X</span>' +
            '</div>' +
            '</div>'
        );
        jQuery('#del-col-' + col_id).bind('click', function () {
            var index = jQuery(this).attr('id').replace('del-col-', '');
            //console.log(index);
            jQuery("#col-container-" + index).remove();
						order('col');
            //col_id--;
            refresh();
        });

        jQuery(".control").bind('change keyup', function () {
            refresh();
        });

        order('col');
        refresh();
    });

    // ADD ROW
    var row_id = 0;
    jQuery("#add_row").click(function () {
        row_id++;
        jQuery("#form #row").append(
            '<div id="row-container-' + row_id + '">' +
            '<label>Row <span>' + row_id + '</span>' +
            ' <input id="row-' + row_id + '" value="1" class="row control" type="number" min="0" /></label>' +
            ' <select id="row-unit-' + row_id + '" class="control">' +
            '<option>fr</option>' +
            '<option>%</option>' +
            '<option>px</option>' +
            '<option>em</option>' +
            '<option>rem</option>' +
            '<option>auto</option>' +
            '</select>' +
            '<span id="del-row-' + row_id + '" class="del">X</span>' +
            '</div>' +
            '</div>'
        );
        //jQuery("#layout").append('<div class="row"></div>');
        jQuery('#del-row-' + row_id).bind('click', function () {
            var index = jQuery(this).attr('id').replace('del-row-', '');
            //console.log(index);
            jQuery("#row-container-" + index).remove();
						order('row');
            //row_id--;
            refresh();
        });

        jQuery(".control").bind('change keyup', function () {
            refresh();
        });

        order('row');
        refresh();
    });

    // ADD ITEM
    var item = 1;
    jQuery("#add_item").click(item, function () {
        item++;
        // ADD CLOSE 'X' TO ITEM
        jQuery("#grid_layout").append('<div class="item" id="item-' + item + '"><label class="item-number-' + item + '">' + item + '</label><span id="del-item-' + item + '">x</span><input id="item-name-' + item + '" class="item-name" value="section_'+item+'"></div>');
        jQuery(this).val('Add item (' + item + ')');

        // ADD REMOVE ACTION TO ITEM
        jQuery("#del-item-" + item).bind('click', item, function (event) {
            var index = jQuery(this).attr('id').replace('del-item-', '');
            jQuery("#del-item-" + index).parent('div').remove();

            item--;
            jQuery('#add_item').val('Add item (' + item + ')');

            order_item();
            refresh();
        });

        // ADD ACTIONS [FOCUS IN, FOCUS OUT] TO [ADD & REMOVE] CLASS TO PARENT DIV
        jQuery("#item-name-" + item).bind('focusin', function () {
            var index = jQuery(this).attr('id').replace('item-name-', '');
            jQuery('#item-' + index).removeClass(jQuery(this).val());
            refresh();
        });
        jQuery("#item-name-" + item).bind('focusout', function () {
            var index = jQuery(this).attr('id').replace('item-name-', '');
            jQuery('#item-' + index).addClass(jQuery(this).val());
            refresh();
        });

        order_item();
        refresh();
    });



    jQuery(".control").on('change keyup', function () {
        refresh();
    });

    jQuery(".item>span").click(item, function () {
        var index = jQuery(this).attr('id').replace('del-item-', '');
        jQuery("#del-item-" + index).parent('div').remove();

        item--;
        jQuery('#add_item').val('Add item (' + item + ')');
        refresh();
    });

    jQuery("[id^=item-name-]").focusin(function () {
        var index = jQuery(this).attr('id').replace('item-name-', '');
        jQuery('#item-' + index).removeClass(jQuery(this).val());
        refresh();
    });
    jQuery("[id^=item-name-]").focusout(function () {
        var index = jQuery(this).attr('id').replace('item-name-', '');
        jQuery('#item-' + index).addClass(jQuery(this).val());
        refresh();
    });

    // CSS STYLE REPLACEMENT
    var current_style =
        '#grid_layout {\n' +
        '\tdisplay: grid;\n' +
        //'    grid-auto-flow:column;\n' +
        '@grid-template-columns' +
        '@grid-template-rows' +
        '@grid-template-areas' +
        '@grid-column-gap' +
        '@grid-row-gap' +
        '@justify' +
        '@align' +
        '}';

    /*
                jQuery("#get_style").click(function () {
                    var areas = jQuery('#section-1').css('grid-template-areas').split(/" "/g); //.replace(/['"]+/g, '');
                    var styles = [];
                    for (var i in areas) {
                        styles[i] = areas[i].replace(/['"]+/g, '').split(" ").map(function (s) {
                            return s.trim()
                        });;
                    }
                    console.log(styles);

                });
    */
    // MAIN FUNCTION 
    jQuery("#get_code").click(function () {
        // GET COLUMNS DATA
        var temp_cols = [];
        jQuery("input[class^='col']").each(function () {
            var index = jQuery(this).attr('id').replace('col-', '');
            var unit = jQuery(this).parent('label').next("select").val();
            if (unit == 'auto') {
                temp_cols[index] = unit; return;
            }
            //temp_cols.push(jQuery(this).val() + unit);
            temp_cols[index] = jQuery(this).val() + unit;

        });

        // GET ROWS DATA
        var temp_rows = [];
        jQuery("input[class^='row']").each(function () {
            var index = jQuery(this).attr('id').replace('row-', '');
            var unit = jQuery(this).parent('label').next('select').val();
            if (unit == 'auto') {
                temp_rows[index] = unit; return;
            }
            //temp_cols.push(jQuery(this).val() + unit);
            //temp_rows.push(jQuery(this).val() + unit);
            temp_rows[index] = jQuery(this).val() + unit;

        });

        // GET ITEMS DATA
        var inputs_val = [];
        jQuery("input[class='item-name']").each(function () {
            var value = jQuery(this).val();
            var index = jQuery(this).attr('id').replace('item-name-', '');
            inputs_val[index] = value;
            //inputs_val.push(value);
        });

        //console.log('temp_cols');
        //console.log(temp_cols);
        //console.log('temp_rows');
        //console.log(temp_rows);
        //console.log('inputs_val');
        //console.log(inputs_val);

        // START CREATE CSS STRING
        var grid_template_columns = '';
        var grid_template_rows = '';
        var grid_template_areas = '';

        grid_template_columns += (temp_cols.length > 0) ? '\tgrid-template-columns: ' : '';
        grid_template_rows += (temp_rows.length > 0) ? '\tgrid-template-rows: ' : '';
        grid_template_areas += '\tgrid-template-areas: ';

        // COLUMNS STRING
        for (var i in temp_cols) {
            grid_template_columns += temp_cols[i] + ' ';
        } // console.log(temp_cols);

        // ROWS STRING
        for (var i in temp_rows) {
            grid_template_rows += temp_rows[i] + ' ';
        }

        // ITEMS STRING
        var x = 0;

        for (var r in temp_rows) {
            grid_template_areas += '"';

            for (var c in temp_cols) {
                if (inputs_val[x]) {
                    grid_template_areas += inputs_val[x] + ' ';
                    x++;
                }
            }
            grid_template_areas += '"\n';
        }

        // ENDING EACH LINE WITH COMMA AND NEW LINE
        if (grid_template_columns != '') grid_template_columns += ";\n";
        if (grid_template_rows != '') grid_template_rows += ";\n";
        if (grid_template_areas != '') grid_template_areas += "\t;\n";

        //console.log(grid_template_areas);

        // GET OTHER DATA
        var col_gap = jQuery('#col_gap').val() != 0 ? '\tgrid-column-gap: ' + jQuery('#col_gap').val() + jQuery('#col_gap').next('select').val() + ";\n" : '';
        var row_gap = jQuery('#row_gap').val() != 0 ? '\tgrid-row-gap: ' + jQuery('#row_gap').val() + jQuery('#row_gap').next('select').val() + ";\n" : '';
        var justify = jQuery('#justify').val() != '' ? '\tjustify-items: ' + jQuery('#justify').val() + ";\n" : '';
        var align = jQuery('#align').val() != '' ? '\talign-items: ' + jQuery('#align').val() + ";\n" : '';

        // REPLACE CSS STYLE "VAR current_style" WITH NEW DATA
        var eol = ";\n";
        var textarea = jQuery(this).val();
        var find = ["@grid-template-columns", "@grid-template-rows", "@grid-template-areas", "@grid-column-gap", "@grid-row-gap", "@justify", "@align"];
        var replace = [grid_template_columns, grid_template_rows, grid_template_areas, col_gap, row_gap, justify, align];
        var code = current_style.replaceArray(find, replace);

        // REMOVE DOUPLICATE ITEMS
        //var first_item = jQuery("#layout > div:first-child > input").val();
        var html = '';
        var unique = [];

        //html += '<div id="'+first_item+'">'+first_item+'</div>';
        var x = 0;
        for (var i in inputs_val) {
            if (unique.indexOf(inputs_val[i]) === -1) { //  jQuery.inArray(inputs_val[i], unique)                          
                unique[x] = inputs_val[i];
                //unique.push(inputs_val[i]);   
                x++;
            }

        }
        //console.log('unique');
        //console.log(unique);

        if (unique.length > 0) {

            for (var u in unique) {

                code += '\n#' + unique[u] + '{grid-area:' + unique[u] + '}';
                html += '<div id="' + unique[u] + '">' + unique[u] + '</div>';
            }
        }

        jQuery("#output").html(html);

        //console.log(code);
        // OUTPUT CODE TO TEXTAREA
        jQuery("textarea#code").html(code);
        //jQuery("#layout").cssText(code);

        // APPLAY NEW CSS 
        //jQuery("style#generate").text(code);
        //var w = grid_template_areas.replaceArray(['"', ';', '\t'], ['', '', '']).split('\n');//.splice(2,2); //.replace(/['"]+/g, '')
        //var w = jQuery('#layout').css('grid-template-areas');//.replaceArray(['"', ';', '\t'], ['', '', '']).split('\n');//.splice(2,2); //.replace(/['"]+/g, '')
        //console.log(w);
        //jQuery("#section-1").addClass('#layout');
        
        var code2 = code.replace('#grid_layout', '#grid_layout, #output')
        jQuery("style#generate").text(code2);

        // SHOW ERRORS
				var temp_cells_length = temp_rows.length * temp_cols.length;
				var remain = temp_cells_length - inputs_val.length;
				
        if (temp_cells_length < inputs_val.length) {
						jQuery('#add_col, #add_row').removeClass('btn-error');
            jQuery('#error').text("Add "+remain*-1+" columns or rows").show();
            jQuery('#add_col, #add_row').addClass('btn-error');
        } 
        else if (temp_cells_length > inputs_val.length) {
						jQuery('#add_col, #add_row').removeClass('btn-error');
            jQuery('#error').text("Add "+remain+" items").show();
            jQuery('#add_item').addClass('btn-error');
        } 
        else {
            jQuery('#error').text("").hide();
            jQuery('#add_col, #add_row, #add_item').removeClass('btn-error');
        }

        /*
        var areas = jQuery('#layout').css('grid-template-areas'); //document.getElementById("output").style.gridTemplateAreas; //
        if(areas=='none'){
            jQuery('#error').text("Rename items correctly").show();
            jQuery('.item-name').addClass('btn-error');
        }
        else{
            jQuery('#error').text("").hide();
            jQuery('.item-name').removeClass('btn-error');
        }
        */
        //console.log('==========================================\n');
    });

    refresh();

    jQuery('#check').click(function(){
         //alert(jQuery('#output').css('grid-template-areas'));
         console.log(jQuery('#output').css('grid-template-areas'));
         console.log(document.getElementById("output").style.gridTemplateAreas);
    })


});
