@extends('adminlte::page')

@if (isset($entity) && $entity!='')
@section('title', __('entity.'.$entity))
@endif

@section('content_header')
<h1>
    @if (isset($entity) && $entity!='')
    {{ __('entity.'.$entity)}}
    @endif
</h1>
@stop

@section('content')
<div class="CEB" id="CEB">
    <div class="CEB__wrapContent df">
        <div class="CEB__left">
            <div class="CEB__row">
                <div class="CEB__text2">Тип забора</div>

                <div class="CEB__wrapParams">

                    <label class="labelCustomRadio labelCustomRadio_js">
                        <input checked class="labelCustomRadio__input CMR__change_js CMR__input_typeZabor_js" type="radio" name="Тип забора" value="Французский забор, Комплектация №1" data-numberType="1">
                        <span class="labelCustomRadio__psevdo_border"></span>
                        <p class="labelCustomRadio__text2">Французский забор, Комплектация №1</p>
                    </label>
                    <label class="labelCustomRadio labelCustomRadio_js">
                        <input class="labelCustomRadio__input CMR__change_js CMR__input_typeZabor_js" type="radio" name="Тип забора" value="Французский забор, Комплектация №2" data-numberType="2">
                        <span class="labelCustomRadio__psevdo_border"></span>
                        <p class="labelCustomRadio__text2">Французский забор, Комплектация №2</p>
                    </label>
                    <label class="labelCustomRadio labelCustomRadio_js">
                        <input class="labelCustomRadio__input CMR__change_js CMR__input_typeZabor_js" type="radio" name="Тип забора" value="Французский забор, Комплектация №3" data-numberType="3">
                        <span class="labelCustomRadio__psevdo_border"></span>
                        <p class="labelCustomRadio__text2">Французский забор, Комплектация №3</p>
                    </label>

                </div>

            </div>
            <div class="CEB__row">
                <div class="CEB__text2">Длина забора, м</div>

                <div class="CEB__wrapSlider">
                    <div class="CEBQuestionW__input-rande-text"><span id="CEB__textLength">0</span> м.</div>
                    <div class="CEBQuestionW__wrap-answer-input-rande">
                        <div id="CEBQuestionW-slide1" class="CEBQuestionW__slider"></div>
                        <input type="hidden" id="CEB__inputLength" name="Длина забора, м: " value="0">
                    </div> <!-- .qCEBQuestionW__wrap-answer-input-rande -->
                    <div class="CEB__wrapData">
                        <span class="CEB__Data">0</span>
                        <span class="CEB__Data">50</span>
                        <span class="CEB__Data">100</span>
                        <span class="CEB__Data">150</span>
                        <span class="CEB__Data">200</span>
                        <span class="CEB__Data">250</span>
                        <span class="CEB__Data">300</span>
                    </div>
                </div>

            </div>
            <div class="CEB__row">
                <div class="CEB__text2">Количество столбов, шт</div>

                <div class="CEB__wrapSlider">
                    <div class="CEBQuestionW__input-rande-text"><span id="CEB__textPost_quantity">0</span> шт.</div>
                    <div class="CEBQuestionW__wrap-answer-input-rande">
                        <div id="CEBQuestionW-slide2" class="CEBQuestionW__slider"></div>
                        <input type="hidden" id="CEB__inputPost_quantity" name="Количество столбов, шт: " value="0">
                    </div> <!-- .qCEBQuestionW__wrap-answer-input-rande -->
                    <div class="CEB__wrapData">
                        <span class="CEB__Data">0</span>
                        <span class="CEB__Data">20</span>
                        <span class="CEB__Data">40</span>
                        <span class="CEB__Data">60</span>
                        <span class="CEB__Data">80</span>
                        <span class="CEB__Data">100</span>
                        <span class="CEB__Data">120</span>
                    </div>
                </div>


            </div>
            <div class="CEB__row">
                <div class="CEB__text2">Высота стенки, см</div>

                <div class="CEB__wrapSlider">
                    <div class="CEBQuestionW__input-rande-text"><span id="CEB__text_wallHeight">0</span> шт.</div>
                    <div class="CEBQuestionW__wrap-answer-input-rande">
                        <div id="CEBQuestionW-slide3" class="CEBQuestionW__slider"></div>
                        <input type="hidden" id="CEB__input_wallHeight" name="Высота стенки, см: " value="0">
                    </div> <!-- .qCEBQuestionW__wrap-answer-input-rande -->
                    <div class="CEB__wrapData">
                        <span class="CEB__Data">80</span>
                        <span class="CEB__Data">120</span>
                        <span class="CEB__Data">160</span>
                        <span class="CEB__Data">200</span>
                        <span class="CEB__Data">240</span>
                        <span class="CEB__Data">280</span>
                        <span class="CEB__Data">320</span>
                    </div>
                </div>

            </div>
            <div class="CEB__row">
                <div class="CEB__text2">Высота колоны, см</div>
                <div class="CEB__wrapSlider">
                    <div class="CEBQuestionW__input-rande-text"><span id="CEB__text_columnHeight">0</span> шт.</div>
                    <div class="CEBQuestionW__wrap-answer-input-rande">
                        <div id="CEBQuestionW-slide4" class="CEBQuestionW__slider"></div>
                        <input type="hidden" id="CEB__input_columnHeight" name="Высота колоны, см: " value="0">
                    </div> <!-- .qCEBQuestionW__wrap-answer-input-rande -->
                    <div class="CEB__wrapData">
                        <span class="CEB__Data">100</span>
                        <span class="CEB__Data">140</span>
                        <span class="CEB__Data">180</span>
                        <span class="CEB__Data">220</span>
                        <span class="CEB__Data">260</span>
                        <span class="CEB__Data">300</span>
                        <span class="CEB__Data">340</span>
                        <span class="CEB__Data">380</span>
                    </div>
                </div>

            </div>
        </div>
        <div class="CEB__right">

            <div class="CEB__row">
                <div class="CEB__text2">Результат</div>
                <div class="CEB__wrapTable" id="CEB__wrapTable"></div>
            </div>
        </div>
    </div>
</div>
@stop

@section('js')
@vite(['resources/css/calculator.css', 'resources/js/jquery-ui.min.js', 'resources/js/jquery.ui.touch-punch.js'])
<script>
    jQuery(document).ready(function($) {
        let resultParams = {
            "block12": {
                "quantity": 0,
                "color": "Серый",
                "weight_one": 12,
                "weight_total": 0,
                "price_gray": `{!! $block12_gray !!}`,
                "price_color": `{!! $block12_color !!}`,
                "price_client": 0,
                "total": 0,
            },
            "column": {
                "quantity": 0,
                "color": "Серый",
                "weight_one": 14,
                "weight_total": 0,
                "price_gray": `{!! $column_gray !!}`,
                "price_color": `{!! $column_color !!}`,
                "price_client": 0,
                "total": 0,
            },
            "cap": {
                "quantity": 0,
                "color": "Серый",
                "weight_one": 14,
                "weight_total": 0,
                "price_gray": `{!! $cap_gray !!}`,
                "price_color": `{!! $cap_color !!}`,
                "price_client": 0,
                "total": 0,
            },
            "parapet": {
                "quantity": 0,
                "color": "Серый",
                "weight_one": 7.5,
                "weight_total": 0,
                "price_gray": `{!! $parapet_gray !!}`,
                "price_color": `{!! $parapet_color !!}`,
                "price_client": 0,
                "total": 0,
            },
            "dekor": {
                "quantity": 0,
                "color": "Серый",
                "weight_one": 4,
                "weight_total": 0,
                "price_gray": `{!! $dekor_gray !!}`,
                "price_color": `{!! $dekor_color !!}`,
                "price_client": 0,
                "total": 0,
            },
        };


        let Length = 10; // длина забора
        let post_quantity = 2; // кол-во столбов
        let wallHeight = 100; // высота стенки
        let columnHeight = 140; // Высота колоны
        let numberType = ""; // номер типа забора


        // let lengthWalls = 0; // 	"Длина стен общая за вычетом длины колонны"	
        // let lengthColumns = 0; // "Длина колонн общая кол-во колонн умноженная на 0,28 (длина колонны)"	
        // let rowsBlocks = 0; // "Рядов блоков в длину по 40 см длина общая без колон деленная на 0,4 +округл"	
        // let verticalRows = 0; // "вертикальных рядов блока  20 см зависит от высоты забора "	

        let weight_zakaz = 0; // вес заказа
        let total_zakaz = 0; // всего за заказ


        let WallSteps = 0; //	Шагов стены
        let rowsBlocks = 0; // Рядов блока
        let lengthWalls = 0; // Длина стен общая
        let lengthColumns = 0; // Длина колонн общая


        MadeSlider_1(); // установка первого ползунка
        MadeSlider_2(); // установка 2 ползунка
        MadeSlider_3(); // установка 3 ползунка
        MadeSlider_4(); // установка 4 ползунка

        calculation();


        // This fixed the conflict between slider and motools
        // jQuery.ui.slider.prototype.widgetEventPrefix = 'slider';


        // Задаем значение первому ползунку
        function MadeSlider_1() {
            jQuery("#CEB__inputLength").val(Length);
            jQuery("#CEB__textLength").text(Length);

            jQuery("#CEBQuestionW-slide1").slider({
                value: Length,
                min: 0,
                max: 300,
                range: 'min',
                step: 0.1,
                animate: true,
                slide: function(event, ui) {
                    Length = ui.value;
                    jQuery("#CEB__inputLength").val(Length);
                    jQuery("#CEB__textLength").text(Length);
                    calculation();
                }
            });
        };

        // Задаем значение 2 ползунку
        function MadeSlider_2() {
            jQuery("#CEB__inputPost_quantity").val(post_quantity);
            jQuery("#CEB__textPost_quantity").text(post_quantity);

            jQuery("#CEBQuestionW-slide2").slider({
                value: post_quantity,
                min: 0,
                max: 120,
                range: 'min',
                step: 1,
                animate: true,
                slide: function(event, ui) {
                    post_quantity = ui.value;
                    jQuery("#CEB__inputPost_quantity").val(post_quantity);
                    jQuery("#CEB__textPost_quantity").text(post_quantity);
                    calculation();
                }
            });
        };

        // Задаем значение 3 ползунку
        function MadeSlider_3() {
            jQuery("#CEB__input_wallHeight").val(wallHeight);
            jQuery("#CEB__text_wallHeight").text(wallHeight);

            jQuery("#CEBQuestionW-slide3").slider({
                value: wallHeight,
                min: 80,
                max: 320,
                range: 'min',
                step: 20,
                animate: true,
                slide: function(event, ui) {
                    wallHeight = ui.value;
                    jQuery("#CEB__input_wallHeight").val(wallHeight);
                    jQuery("#CEB__text_wallHeight").text(wallHeight);
                    calculation();
                }
            });
        };

        // Задаем значение 4 ползунку
        function MadeSlider_4() {
            jQuery("#CEB__input_columnHeight").val(columnHeight);
            jQuery("#CEB__text_columnHeight").text(columnHeight);

            jQuery("#CEBQuestionW-slide4").slider({
                value: columnHeight,
                min: 100,
                max: 380,
                range: 'min',
                step: 20,
                animate: true,
                slide: function(event, ui) {
                    columnHeight = ui.value;
                    jQuery("#CEB__input_columnHeight").val(columnHeight);
                    jQuery("#CEB__text_columnHeight").text(columnHeight);
                    calculation();
                }
            });
        };


        $("body").on("change", ".CMR__change_js", function() {
            calculation();
        });

        $("body").on("change", ".CEB__select_color_js", function() {

            let name_tovar = $(this).attr("data-nameTovar");

            resultParams[`${name_tovar}`]["color"] = $(this).val();

            calculation();
        });

        function calculation() {


            numberType = +$(".CMR__input_typeZabor_js:checked").attr("data-numberType");

            lengthColumns = Length - post_quantity;

            lengthWalls = Length - (post_quantity * 0.28);

            if (numberType == 1) {
                rowsBlocks = wallHeight / 20;
            } else if (numberType == 2) {
                rowsBlocks = wallHeight / 20 - 1;
            } else if (numberType == 3) {
                rowsBlocks = wallHeight / 20 - 1;
            };

            WallSteps = lengthWalls / 0.4;
            WallSteps = Math.ceil(WallSteps);

            // Блок 12
            resultParams["block12"]["quantity"] = +(WallSteps * rowsBlocks).toFixed(2);
            resultParams["block12"]["weight_total"] = +(resultParams["block12"]["quantity"] * resultParams["block12"]["weight_one"]).toFixed(2);

            // цена цвета
            if (resultParams["block12"]["color"] == "Серый") {
                resultParams["block12"]["price_client"] = resultParams["block12"]["price_gray"];
            } else {
                resultParams["block12"]["price_client"] = resultParams["block12"]["price_color"];
            };

            resultParams["block12"]["total"] = +(resultParams["block12"]["quantity"] * resultParams["block12"]["price_client"]).toFixed(2);
            // Блок 12


            // Колонн
            resultParams["column"]["quantity"] = +(post_quantity * columnHeight / 20).toFixed(2);
            resultParams["column"]["weight_total"] = +(resultParams["column"]["quantity"] * resultParams["column"]["weight_one"]).toFixed(2);

            // цена цвета
            if (resultParams["column"]["color"] == "Серый") {
                resultParams["column"]["price_client"] = resultParams["column"]["price_gray"];
            } else {
                resultParams["column"]["price_client"] = resultParams["column"]["price_color"];
            };

            resultParams["column"]["total"] = +(resultParams["column"]["quantity"] * resultParams["column"]["price_client"]).toFixed(2);
            // Колонн






            // Крышек
            resultParams["cap"]["quantity"] = +(post_quantity).toFixed(2);
            resultParams["cap"]["weight_total"] = +(resultParams["cap"]["quantity"] * resultParams["cap"]["weight_one"]).toFixed(2);

            // цена цвета
            if (resultParams["cap"]["color"] == "Серый") {
                resultParams["cap"]["price_client"] = resultParams["cap"]["price_gray"];
            } else {
                resultParams["cap"]["price_client"] = resultParams["cap"]["price_color"];
            };

            resultParams["cap"]["total"] = +(resultParams["cap"]["quantity"] * resultParams["cap"]["price_client"]).toFixed(2);
            // Крышек




            // Парапет
            if (numberType == 1) {
                resultParams["parapet"]["quantity"] = +(WallSteps).toFixed(2);
            } else if (numberType == 2) {
                resultParams["parapet"]["quantity"] = +(WallSteps).toFixed(2);
            } else if (numberType == 3) {
                resultParams["parapet"]["quantity"] = +(WallSteps * 3).toFixed(2);
            };
            resultParams["parapet"]["weight_total"] = +(resultParams["parapet"]["quantity"] * resultParams["parapet"]["weight_one"]).toFixed(2);


            // цена цвета
            if (resultParams["parapet"]["color"] == "Серый") {
                resultParams["parapet"]["price_client"] = resultParams["parapet"]["price_gray"];
            } else {
                resultParams["parapet"]["price_client"] = resultParams["parapet"]["price_color"];
            };

            resultParams["parapet"]["total"] = +(resultParams["parapet"]["quantity"] * resultParams["parapet"]["price_client"]).toFixed(2);
            // Парапет




            // Декора
            if (numberType == 1) {
                resultParams["dekor"]["quantity"] = 0;
            } else if (numberType == 2) {
                resultParams["dekor"]["quantity"] = +(WallSteps * 2).toFixed(2);
            } else if (numberType == 3) {
                resultParams["dekor"]["quantity"] = +(WallSteps * 2).toFixed(2);
            };

            resultParams["dekor"]["weight_total"] = +(resultParams["dekor"]["quantity"] * resultParams["dekor"]["weight_one"]).toFixed(2);

            // цена цвета
            if (resultParams["dekor"]["color"] == "Серый") {
                resultParams["dekor"]["price_client"] = resultParams["dekor"]["price_gray"];
            } else {
                resultParams["dekor"]["price_client"] = resultParams["dekor"]["price_color"];
            };

            resultParams["dekor"]["total"] = +(resultParams["dekor"]["quantity"] * resultParams["dekor"]["price_client"]).toFixed(2);
            // Декора




            // Доставка


            // общий вес
            weight_zakaz = +resultParams["block12"]["weight_total"] +
                resultParams["column"]["weight_total"] +
                resultParams["cap"]["weight_total"] +
                resultParams["parapet"]["weight_total"] +
                resultParams["dekor"]["weight_total"];

            weight_zakaz = +weight_zakaz.toFixed(2);

            // стоимость заказа
            total_zakaz = +resultParams["block12"]["total"] +
                resultParams["column"]["total"] +
                resultParams["cap"]["total"] +
                resultParams["parapet"]["total"] +
                resultParams["dekor"]["total"];

            total_zakaz = +total_zakaz.toFixed(2);
            makeTable();

        };

        function makeTable() {

            $("#CEB__wrapTable").empty();

            let optionsTableColor = `<option value="Серый" data-codeColor="#E6E6E6" data-codecolortext="#000">Серый</option>
			<option value="Красный" data-codeColor="#B10202" data-codecolortext="#fff">Красный</option>
			<option value="Жёлтый" data-codeColor="#FFE5A0" data-codecolortext="#000">Жёлтый</option>
			<option value="Коричневый" data-codeColor="#753800" data-codecolortext="#fff">Коричневый</option>`;

            let tableResult =
                `
			<table class="CEB__table">
					<tr>
							<td>позиция</td>
							<td>кол-во</td>
							<td>цвет</td>
							<td>вес, кг</td>
							<td>цена, руб/ед</td>
							<td>сумма, руб</td>
					</tr>
					<tr>
							<td>блок 12</td>
							<td>${resultParams["block12"]["quantity"]}</td>
							<td>
							<select name="цвет блока" data-nameTovar="block12" class="CEB__select_color_js CEB__select_color" value="10">
								${optionsTableColor}
							</select>
							</td>
							<td>${resultParams["block12"]["weight_total"]}</td>
							<td>${resultParams["block12"]["price_client"]}</td>
							<td>${resultParams["block12"]["total"]}</td>
					</tr>
					<tr>
							<td>колонн</td>
							<td>${resultParams["column"]["quantity"]}</td>
							<td>
							<select name="цвет колонн" data-nameTovar="column" class="CEB__select_color_js CEB__select_color">
								${optionsTableColor}
							</select>
							</td>
							<td>${resultParams["column"]["weight_total"]}</td>
							<td>${resultParams["column"]["price_client"]}</td>
							<td>${resultParams["column"]["total"]}</td>
					</tr>
					<tr>
							<td>крышек</td>
							<td>${resultParams["cap"]["quantity"]}</td>
							<td>
							<select name="цвет крышек"  data-nameTovar="cap" class="CEB__select_color_js CEB__select_color">
								${optionsTableColor}
							</select>
							</td>
							<td>${resultParams["cap"]["weight_total"]}</td>
							<td>${resultParams["cap"]["price_client"]}</td>
							<td>${resultParams["cap"]["total"]}</td>
					</tr>
					<tr>
							<td>парапет</td>
							<td>${resultParams["parapet"]["quantity"]}</td>
							<td>
							<select name="цвет парапета"  data-nameTovar="parapet" class="CEB__select_color_js CEB__select_color">
								${optionsTableColor}
							</select>
							</td>
							<td>${resultParams["parapet"]["weight_total"]}</td>
							<td>${resultParams["parapet"]["price_client"]}</td>
							<td>${resultParams["parapet"]["total"]}</td>
					</tr>
					<tr>
							<td>декора</td>
							<td>${resultParams["dekor"]["quantity"]}</td>
							<td>
							<select name="цвет декора"  data-nameTovar="dekor" class="CEB__select_color_js CEB__select_color">
								${optionsTableColor}
							</select>
							</td>
							<td>${resultParams["dekor"]["weight_total"]}</td>
							<td>${resultParams["dekor"]["price_client"]}</td>
							<td>${resultParams["dekor"]["total"]}</td>
					</tr>
					<tr>
							<td>итог:</td>
							<td></td>
							<td></td>
							<td>${weight_zakaz}</td>
							<td></td>
							<td>${total_zakaz}</td>
					</tr>
			</table>
		`;

            // выводим таблицу
            CEB__wrapTable.insertAdjacentHTML('beforeend', tableResult);

            // заменяем на ранее выбранный цвет

            for (let key in resultParams) {
                $("body").find(`[data-nameTovar='${key}']`).find(`option[value='${resultParams[key]["color"]}']`).prop('selected', true);
            };

            $("body").find(".CEB__select_color_js").each(function() {
                $(this).css({
                    "backgroundColor": $(this).find("option:selected").attr("data-codecolor"),
                    "color": $(this).find("option:selected").attr("data-codecolortext"),
                });
            });
        }
    }); //end function
</script>
@stop
@include('Dashboard.components.style')