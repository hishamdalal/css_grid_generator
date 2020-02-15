<?php
session_start();
define('INDEX', true);
include 'inc/record_visitors.class.php';
$visitor = new recordVisitors();
$visitor->set_path('admin/data');
$visitor->record();
#echo '<br>';
#echo $visitor->get_count();
#echo '<pre>';
#echo $visitor->get_current();
?>
<!DOCTYPE html>
<html lang="en" class="">

<head>
    <!-- Mobile Specific Meta -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Favicon--
    <link rel="shortcut icon" href="img/favicon/favicon-32x32.png">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="img/favicon/apple-touch-icon-144x144.png" />
    <link rel="apple-touch-icon-precomposed" sizes="152x152" href="img/favicon/apple-touch-icon-152x152.png" />
    <link rel="icon" type="image/png" href="img/favicon/favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="img/favicon/favicon-16x16.png" sizes="16x16" />

    <meta name="application-name" content="CSS Grid Generation" />
    <meta name="msapplication-TileColor" content="#FFFFFF" />
    <meta name="msapplication-TileImage" content="img/favicon/mstile-144x144.png" />
		-->

    <!-- Author Meta -->
    <meta name="author" content="HishamDalal">
    <!-- Meta Description -->
    <meta name="description" content="css grid generator online">
    <!-- Meta Keyword -->
    <meta name="keywords" content="css, grid, generator, online">
    <!-- meta character set -->
    <meta charset="UTF-8">
    <!-- Site Title -->
    <title>CSS Grid Generator</title>

    <link rel="stylesheet" href="assets/css/normalize.css">
    <link rel="stylesheet" href="assets/css/main.css">
    <style id="generate"></style>

</head>

<body>
    <section id="container">
			<header>
				<h2>CSS Grid Generator</h2>
			</header>

        <div id="form">

            <div id="col">
                <h3>Grid Template Columns <span>(i)</span></h3>
                <p>grid-template-columns defines how the elements will be divided into vertical columns and how they will be sized in relation to each other.</p>

                <button id="add_col">Add Column</button><br>
                <div id="col-container-0"><label>Column <span>0</span> <input id="col-0" class="col control" value="1" type="number" min="0"></label>
                    <select id="col-unit-0" class="control">
                        <option>fr</option>
                        <option>%</option>
                        <option>px</option>
                        <option>em</option>
                        <option>rem</option>
                        <option>auto</option>
                    </select></div>
            </div>

            <div id="row">
                <h3>Grid Template Rows <span>(i)</span></h3>
                <p>grid-template-rows defines how the elements will be divided into <strong>horizontal rows</strong> and how they will be sized in relation to each other.</p>
                <button id="add_row">Add row</button><br>
                <div id="row-container-0"><label>Row <span>0</span> <input id="row-0" class="row control" value="1" type="number" min="0"></label>
                    <select id="row-unit-0" class="control">
                        <option>fr</option>
                        <option>%</option>
                        <option>px</option>
                        <option>em</option>
                        <option>rem</option>
                        <option>auto</option>
                    </select></div>
            </div>

            <div id="item">
                <input id="add_item" value="Add item" type="button" />
            </div>

            <div>
                <h3>Grid Column Gap <span>(i)</span></h3>
                <p>Defines the horizontal space <strong>between</strong> all columns.</p>
                <input id="col_gap" value="5" type="number" min="0" class="control" />
                <select class="control">
                    <option>fr</option>
                    <option>%</option>
                    <option selected>px</option>
                    <option>em</option>
                    <option>rem</option>
                    <option>cm</option>
                </select>

            </div>

            <div>
                <label>
                    <h3>Grid Row Gap <span>(i)</span></h3>
                    <p>Defines the vertical space <strong>between</strong> all rows.</p>
                    <input id="row_gap" value="5" type="number" min="0" class="control" />
                    <select class="control">
                        <option>fr</option>
                        <option>%</option>
                        <option selected>px</option>
                        <option>em</option>
                        <option>rem</option>
                        <option>cm</option>
                    </select>
                </label>

            </div>

            <div>
                <label>
                    <h3>Justify Items <span>(i)</span></h3>
                    <p>Defines how the items will be aligned <strong>horizontally</strong> in each column.</p>
                    <select id="justify" class="control">
                        <option val="stretch">stretch</option>
                        <option val="center">center</option>
                        <option val="start">start</option>
                        <option val="end">end</option>
                        <option val="space-around" style="display: none;">space-around</option>
                        <option val="space-between" style="display: none;">space-between</option>
                        <option val="space-evenly" style="display: none;">space-evenly</option>
                    </select>
                </label>
            </div>

            <div>
                <label>
                    <h3>Align Items <span>(i)</span></h3>
                    <p>Defines how the items will be aligned <strong>vertically</strong> in each row.</p>
                    <select id="align" class="control">
                        <option val="stretch">stretch</option>
                        <option val="center">center</option>
                        <option val="start">start</option>
                        <option val="end">end</option>
                        <option val="space-around" style="display: none;">space-around</option>
                        <option val="space-between" style="display: none;">space-between</option>
                        <option val="space-evenly" style="display: none;">space-evenly</option>
                    </select>
                </label>
            </div>

            <div>
                <input id="get_code" value="Get code" type="button" />
            </div>


        </div>

        <div id="code-container">
            <textarea id="code" cols="40" rows="10"></textarea>
        </div>

        <div id="grid_layout">
            <div id="item-0" class="item"><label class="item-number-0">0</label><span id="del-item-0">x</span><input id="item-name-0" class="item-name" value="section_1"></div>
        </div>
        
        <div id="preview">
					<h4>Preview</h4>
            <div id="error"></div>
            <div id="output"></div>
        </div>

			<footer>
			<p>Programming by <span>HishamDalal</span></p>
			</footer>
    </section>
    <!--button id="check">Check</button-->


    <script src="assets/js/jquery-2.2.4.min.js"></script>
    <script src="assets/js/main.js"></script>

    <script>
    </script>

</body>

</html>
