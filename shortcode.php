<?php
$dir = plugin_dir_url(__FILE__);
?>
<style>
.kals h5 {
    font-size: 12px;
}

p {
    font-size: 11px;
}

.box {
    margin: auto 10px;
    border-radius: 6px;
    padding: 5px 10px;
}

.box:hover {
    background-color: #EDEDED;
    background-image: url(<?php echo $dir; ?>img/hover-circle.png);
    background-position: center 0;
    background-size: 80% 80%;
    /*margin: auto 40px;*/
    border-radius: 6px;
    background-repeat: no-repeat;
}

.person {
    background-image: url(<?php echo $dir; ?>img/one-person.png);
}

.tow-people {
    background-image: url(<?php echo $dir; ?>img/tow-people.png);
}

.four-people {
    background-image: url(<?php echo $dir; ?>img/four-people.png);
}

.cc-selector input {
    margin: 0;
    padding: 0;
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
}

.drinkcard-cc {
    cursor: pointer;
    background-size: contain;
    background-repeat: no-repeat;
    display: inline-block;
    width: 97px;
    height: 97px;
    -webkit-transition: all 100ms ease-in;
    -moz-transition: all 100ms ease-in;
    transition: all 100ms ease-in;
    /*-webkit-filter: brightness(1.8) grayscale(1) opacity(.7);
    -moz-filter: brightness(1.8) grayscale(1) opacity(.7);
    filter: brightness(1.8) grayscale(1) opacity(.7);*/
}

.drinkcard-cc:hover {
    /*-webkit-filter: brightness(1.2) grayscale(.5) opacity(.9);
    -moz-filter: brightness(1.2) grayscale(.5) opacity(.9);
    filter: brightness(1.2) grayscale(.5) opacity(.9);*/
}

.cc-selector input:checked+.drinkcard-cc {
    /*-webkit-filter: none;
    -moz-filter: none;
    filter: none;
    background-color: #EDEDED;
    background-image: url(<?php echo $dir; ?>img/hover-circle.png);
    background-position: center center;
    background-size: 100% 100%;
    margin: auto 40px;
    border-radius: 6px;
    background-repeat: no-repeat;*/
}

.persons {
    background-position: center 0;
    background-size: 80% 80%;
    background-repeat: no-repeat;
}

.calendar {
    background-image: url(<?php echo $dir; ?>img/calendar.png);
}

.calendars {
    background-position: center 0;
    background-size: 80% 80%;
    background-repeat: no-repeat;

}

.meal {
    background-image: url(<?php echo $dir; ?>img/meal.png);
}

.meals {
    background-position: center 0;
    background-size: 80% 80%;
    background-repeat: no-repeat;
}

.kal_box {
    margin: auto 10px;
    border-radius: 6px;
    padding: 5px 10px;
}

.kal_box:hover {
    background-color: #EDEDED;
    background-image: url(<?php echo $dir; ?>img/hover-circle.png);
    background-position: 30px -5px;
    background-size: 70% 70%;
    /*margin: auto 40px;*/
    border-radius: 6px;
    background-repeat: no-repeat;
}

.own {
    background-image: url(<?php echo $dir; ?>img/own.png);
}

.balance {
    background-image: url(<?php echo $dir; ?>img/balance.png);
}

.subst {
    background-image: url(<?php echo $dir; ?>img/subst.png);
}

.lose {
    background-image: url(<?php echo $dir; ?>img/lose.png);
}

.kals {
    background-position: 30px -5px;
    background-size: 70% 70%;
    background-repeat: no-repeat;

}

.set-row .box {
    width: 12.28%;
    float: left;
}

@media screen and (max-width: 1024px) {
    .set-row .box {
        width: 15.28%;
        float: left;
    }
}

@media screen and (max-width: 768px) {
    .set-row .box {
        width: 18.28%;
        float: left;
    }
}

@media screen and (max-width: 425px) {
    .set-row .box {
        width: 20.28%;
        float: left;
    }

    .calendars {
        width: 115px !important;

    }

    .text-secondary {
        float: left !important;
    }
}

@media screen and (max-width: 375px) {
    .set-row .box {
        width: 50.28%;
        float: left;
    }

    .calendars {
        width: 115px !important;

    }

    .text-secondary {
        float: left !important;
    }
}

@media screen and (max-width: 320px) {
    .set-row .box {
        width: 50.28% !important;
        float: left;
    }

    .calendars {
        width: 115px !important;

    }

    .text-secondary {
        float: left !important;
    }
}
</style>
<form method="post" class="intial_questions" action="/hunger/select-meals/">
<div style="padding-top: 20px; padding-bottom: 20px;">
    <div class="container">
        <div class="row justify-content-center">
            <div class=" col-lg-6 col-md-6 col-sm-12 col-xs-12 text-left align-self-center">
                <h4>How many people is this for?</h4>
            </div>
            <div class=" col-lg-6 col-md-6 col-sm-12 col-xs-12  align-self-center">
                <h6 class="text-right text-secondary">Please click on your desired option</h6>
            </div>
        </div>
    </div>
</div>
<div class="text-center">
    <div class="container">
        <div class="row justify-content-center cc-selector">
            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 ">
                <div class="box persons person_1">
                    <input id="person" type="radio" name="person" value="1" onclick="check_person(this.value)" />
                    <label class="drinkcard-cc person" for="person"></label>
                    <h5>1 Person</h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 ">
                <div class="box persons person_2">
                    <input id="tow-people" type="radio" name="person" value="2" onclick="check_person(this.value)" />
                    <label class="drinkcard-cc tow-people" for="tow-people"></label>
                    <h5>2 People</h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 ">
                <div class="box persons person_4">
                    <input id="four-people" type="radio" name="person" value="4" onclick="check_person(this.value)" />
                    <label class="drinkcard-cc four-people" for="four-people"></label>
                    <h5>4 People</h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 "></div>
        </div>
    </div>
</div>
<div style="padding-top: 20px; padding-bottom: 20px;">
    <div class="container">
        <div class="row justify-content-center">
            <div class=" col-lg-12 col-md-12 col-sm-12 col-xs-12 text-left align-self-center">
                <h4>How many days, per week, would you like the meals?</h4>
            </div>
        </div>
    </div>
</div>
<div class="text-center">
    <div class="container">
        <div class="row set-row p-3 cc-selector justify-content-center">
            <div class="box calendars calendar_1">
                <input id="1-days" type="radio" name="calendar" value="1" onclick="check_calendar(this.value)" />
                <label class="drinkcard-cc calendar" for="1-days"></label>
                <h5>1 day</h5>
            </div>
            <div class="box calendars calendar_2">
                <input id="2-days" type="radio" name="calendar" value="2" onclick="check_calendar(this.value)" />
                <label class="drinkcard-cc calendar" for="2-days"></label>
                <h5>2 days</h5>
            </div>
            <div class="box calendars calendar_3">
                <input id="3-days" type="radio" name="calendar" value="3" onclick="check_calendar(this.value)" />
                <label class="drinkcard-cc calendar" for="3-days"></label>
                <h5>3 days</h5>
            </div>
            <div class="box calendars calendar_4">
                <input id="4-days" type="radio" name="calendar" value="4" onclick="check_calendar(this.value)" />
                <label class="drinkcard-cc calendar" for="4-days"></label>
                <h5>4 days</h5>
            </div>
            <div class="box calendars calendar_5">
                <input id="5-days" type="radio" name="calendar" value="5" onclick="check_calendar(this.value)" />
                <label class="drinkcard-cc calendar" for="5-days"></label>
                <h5>5 days</h5>
            </div>
            <div class="box calendars calendar_6">
                <input id="6-days" type="radio" name="calendar" value="6" onclick="check_calendar(this.value)" />
                <label class="drinkcard-cc calendar" for="6-days"></label>
                <h5>6 days</h5>
            </div>
            <div class="box calendars calendar_7">
                <input id="7-days" type="radio" name="calendar" value="7" onclick="check_calendar(this.value)" />
                <label class="drinkcard-cc calendar" for="7-days"></label>
                <h5>7 days</h5>
            </div>
        </div>
    </div>
</div>
<div style="padding-top: 20px; padding-bottom: 20px;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12  text-left align-self-center">
                <h4>How many meals, per day, would you like?</h4>
            </div>
        </div>
    </div>
</div>
<div class="text-center">
    <div class="container">
        <div class="row justify-content-center cc-selector">
            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 ">
                <div class="box meals meal_1">
                    <input id="1-meals" type="radio" name="meal" value="1" onclick="check_meal(this.value)" />
                    <label class="drinkcard-cc meal" for="1-meals"></label>
                    <h5>1 meal per day</h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 ">
                <div class="box meals meal_2">
                    <input id="2-meals" type="radio" name="meal" value="2" onclick="check_meal(this.value)" />
                    <label class="drinkcard-cc meal" for="2-meals"></label>
                    <h5>2 meals per day</h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 ">
                <div class="box meals meal_3">
                    <input id="3-meals" type="radio" name="meal" value="3" onclick="check_meal(this.value)" />
                    <label class="drinkcard-cc meal" for="3-meals"></label>
                    <h5>3 meals per day</h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 "></div>
        </div>
    </div>
</div>
<div style="padding-top: 20px; padding-bottom: 20px;">
    <div class="container">
        <div class="row justify-content-center">
            <div class=" col-lg-12 col-md-12 col-sm-12 col-xs-12  text-left align-self-center">
                <h4>What type of meals would you like?</h4>
            </div>
        </div>
    </div>
</div>
<div class="text-center">
    <div class="container">
        <div class="row cc-selector">
            <!--<div class=" col-lg-3 col-md-3 col-sm-12 col-xs-12 ">
                <div class="kal_box kals kal_1">
                    <input id="own" type="radio" name="kal" value="1" onclick="check_kal(this.value)" />
                    <label class="drinkcard-cc own" for="own"></label>
                    <h5>I want to create my own</h5>
                    <p>(around 400-600kcals, per meal)</p>
                </div>
            </div>-->
            <div class=" col-lg-3 col-md-3 col-sm-12 col-xs-12 ">
                <div class="kal_box kals kal_1">
                    <input id="lose" type="radio" name="kal" value="1" onclick="check_kal(this.value)" />
                    <label class="drinkcard-cc lose" for="lose"></label>
                    <h5>I want to eat nutritious, lean, meals</h5>
                    <p>(around 350kcals, per meal)</p>
                </div>
            </div>
            <div class=" col-lg-3 col-md-3 col-sm-12 col-xs-12 ">
                <div class="kal_box kals kal_2">
                    <input id="balance" type="radio" name="kal" value="2" onclick="check_kal(this.value)" />
                    <label class="drinkcard-cc balance" for="balance"></label>
                    <h5>I want to eat nutritious, balanced, meals</h5>
                    <p>(around 450kcals, per meal)</p>
                </div>
            </div>
            <div class=" col-lg-3 col-md-3 col-sm-12 col-xs-12 ">
                <div class="kal_box kals kal_3">
                    <input id="subst" type="radio" name="kal" value="3" onclick="check_kal(this.value)" />
                    <label class="drinkcard-cc subst" for="subst"></label>
                    <h5>I want to eat nutritious, substantial, meals</h5>
                    <p>(around 550kcals, per meal)</p>
                </div>
            </div>
        </div>
    </div>
</div>

</form>
<script type="text/javascript">
function check_person(id) {
    //jQuery(".person_"+id).css("background-image","url("+<?php echo $dir; ?>+"img/hover-circle.png)");
    jQuery(".persons").css("background-image", "").css('background-color', '');
    var img = "<?php echo $dir; ?>img/hover-circle.png";
    jQuery(".person_" + id).css('background-image', 'url(' + img + ')').css('background-color', '#EDEDED');
    calculate_final();
}

function check_calendar(id) {
    jQuery(".calendars").css("background-image", "").css('background-color', '');
    var img = "<?php echo $dir; ?>img/hover-circle.png";
    jQuery(".calendar_" + id).css('background-image', 'url(' + img + ')').css('background-color', '#EDEDED');
    calculate_final();
}

function check_meal(id) {
    jQuery(".meals").css("background-image", "").css('background-color', '');
    var img = "<?php echo $dir; ?>img/hover-circle.png";
    jQuery(".meal_" + id).css('background-image', 'url(' + img + ')').css('background-color', '#EDEDED');
    calculate_final();
}

function check_kal(id) {
    jQuery(".kals").css("background-image", "").css('background-color', '');
    var img = "<?php echo $dir; ?>img/hover-circle.png";
    jQuery(".kal_" + id).css('background-image', 'url(' + img + ')').css('background-color', '#EDEDED');
    calculate_final();
}

function calculate_final() {
    var person = jQuery('input[name=person]:checked').val();
    var calendar = jQuery('input[name=calendar]:checked').val();
    var meal = jQuery('input[name="meal"]:checked').val();
    var kal = jQuery('input[name="kal"]:checked').val();
    if (typeof person != 'undefined') {
        person = person;
    } else {
        person = "";
    }

    if (typeof calendar != 'undefined') {
        calendar = calendar;
    } else {
        calendar = "";
    }
    if (typeof meal != 'undefined') {
        meal = meal;
    } else {
        meal = "";
    }
    if (typeof kal != 'undefined') {
        kal = kal;
    } else {
        kal = "";
    }
    if (person != '' && calendar != '' && meal != '' && kal != '') {
        //alert('person :' +person+ ' calendar : ' +calendar+ ' meal :' +meal+ ' kal :' +kal);
        //window.location.href = "/hunger/select-meals/";
        jQuery('.intial_questions').submit();
    } else {
        //alert('person :' +person+ ' calendar : ' +calendar+ ' meal :' +meal+ ' kal :' +kal);
    }
    //alert('Person'+person+'calendar'+calendar+'meal'+meal+'kal'kal);
}
</script>