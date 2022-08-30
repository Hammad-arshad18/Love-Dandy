<script>
    const config = {
        headers:{
            'Content-Type':'application/json'
        }
    }

    var data = {
        foods:{
            options:[],
            other:''
        },
        anxious:{
            options:[],
            other:''
        },

    }

    var count=1,q=1,tot=23,v1;

    var username;var dogname;
    var genderLabel;
    var city,experience,user_email;
    var listOfCities = [];
    function moveToPreviousQuestion() {

        if(count !==1){
            q-=1;
            renderQuestion(count-1);
        }

    }


</script>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Quiz - Get Started</title>
    <link rel="stylesheet" href="css/bootstrap.min.css"/>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <link rel="stylesheet" href="'css/Quiz.css">
    <script src="js/jQuery.js"></script></head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-white sticky-md-top shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="{{route('welcome')}}">dandy</a>
    </div>
</nav>

<!--Body Started-->
<section class="main-container">
    <div class="name text-center container">
        <h6 id="quest">QUESTION 1/23</h6>

        <span id="content">
            <h1 id="th">Hey, human! What’s your name?</h1>
           <div class="row justify-content-center">
            <div class="col-md-8">
                <input type="text"   class="form-control" placeholder="Type Your Name Here" autofocus id="inputer" name="full_name"/>
                <span id="datalist"></span>
            </div>
        </div>
        </span>
        <div class="row  justify-content-center">
            <div class="col-md-8">
                <a onclick="moveToPreviousQuestion()" id="back_btn" style="cursor: pointer"><i class="fas fa-arrow-left fa-3x"></i></a>
                <button class="btn btn-dark next" id="next-btn">Next</button>
            </div>
        </div>

    </div>


</section>
<!--Body End-->

<!--JS-->

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>


    function changeValue(name,value, flag = false){
        if(flag){
            //if true then push
            switch (name) {
                case 'foods':
                case 'anxious':
                    data[name].options.includes(value) ? data[name].options.splice(data[name]['options'].indexOf(value),1): data[name].options.push(value);
                    break;
            }
        }else{
            data[name] = value;
        }

        console.log(data);
    }
    $(document).ready(function () {
        $("#inputer").on("change paste cut select", function() {
            data[($(this).attr('name'))] = $(this).val();
            console.log(data);
        });

    })
    function createDataListOptions(data){
        var list = ' <datalist id="datalistOptions">\n' +

            '                </datalist>';
        document.getElementById('datalist').innerHTML = list;
    }
    function fetchCities() {
        const data = {

            "operationName":	"CitySearch",
            "query":	"query CitySearch($keyword: String!) {\n Cities(keyword: $keyword) {\n id\n city_full\n __typename\n }\n}\n",
            "variables" :	{
                "keyword":	"L"
            }
        };

        createDataListOptions();
        axios.post('https://dandy-production-graphql.herokuapp.com/graphql',data,config).then((response)=>{
            listOfCities = (response.data).data['Cities'];

            var option;
            const element = document.getElementById('datalistOptions')
            listOfCities.map((city)=>{
                $('#datalistOptions').append($('<option>',{value:  city.city_full.id,text: city.city_full}))
            })


        })
    }


    function renderQuestion(question = false){
        console.log(data);
        if(question){
            count = question;
        }else{
            count+=1;
            q+=1;
        }


        if(count === 1){
            var html = '<h1 id="th">Hey, human! What’s your name?</h1>\n' +
                '           <div class="row justify-content-center">\n' +
                '            <div class="col-md-8">\n' +
                '                <input type="text"   class="form-control" placeholder="Type Your Name Here" autofocus id="inputer" name="full_name"/>\n' +
                '            </div>\n' +
                '        </div>';
            document.getElementById('content').innerHTML = html;
        }

        if(count === 2) {

            username = $("#inputer").val() === undefined ? username : $("#inputer").val();
            v2 = $("#quest").text("QUESTION " + q + "/"+tot);
            $("#th").text("Oh Hi, " + username + ".Where do you and your pack live?");
            p1 = $("<p></p>").text("We use your location to identify environmental factors that can affect your pet’s health");
            $("#th").append(p1);

            $("#inputer").val("");


            document.getElementById('inputer').addEventListener('keyup',function () {
                fetchCities();
            })
            $("#inputer").attr("placeholder", "Start Searching For Your City");
            $("#inputer").attr("list", "datalistOptions");
            $("#inputer").attr("name", "city");


        }
        if(count===3){

            v2 = $("#quest").text("QUESTION " + q + "/"+tot);
            $("#th").text("When it comes to pet supplements you are a …");
            $("#inputer").remove();
            var radio1='<div class="form-group">' +
                '            <input type="radio" name="experience" class="form-check-input" value="187"/>' +
                '            <label>Newbie</label>' +
                '            <input type="radio" name="experience" class="form-check-input" value="188"/>' +
                '            <label>General fan</label>' +
                '            <input type="radio" name="experience" class="form-check-input" value="189"/>' +
                '            <label>Expert</label>' +
                '        </div>';
            $("#th").append(radio1);
            $('input[type=radio][name=experience]').change(function () {
                data[($(this).attr('name'))] = $(this).val();

            })
        }
        if(count === 4){
            v2 = $("#quest").text("QUESTION " + q + "/"+tot);
            $("#th").text("Cool - we’ll meet you on your level. Now for your dog!");
            p1=$("<p class='my-4'></p>").text("Now it gets fun. These next questions will help us find the supplements best-tailored to your dog’s individual needs.");
            $("#th").append(p1);
            $("#next-btn").html("Continue");
        }
        if(count===5){

            v2 = $("#quest").text("QUESTION " + q + "/"+tot);
            $("#th").text("First, we need your email to save your dog’s profile.");
            inp = '<div class="row justify-content-center mt-5">' +
                '            <div class="col-md-8">' +
                '                <input type="text" onchange="changeValue('+"'user_email'"+',this.value)"  class="form-control" id="inputer" placeholder="Enter Your Email" name="user_email" autofocus required/>' +
                '            </div>' +
                '        </div>';
            $("#th").append(inp);
            $("#next-btn").html("Next");

        }
        if(count===6){
            v2 = $("#quest").text("QUESTION " + q + "/"+tot);
            $("#th").text("What’s your dog’s name?");
            p1=$("<p></p>").text("More than one dog? Good! We’ll add in the rest of the pack at the end.");
            $("#th").append(p1);
            inp='<div class="row justify-content-center mt-5">' +
                '            <div class="col-md-8">' +
                '                <input type="text" class="form-control" id="inputer" name="dog_name"  autofocus required/>' +
                '            </div>' +
                '        </div>';
            $("#th").append(inp);
            $('input[type=text][name=dog_name]').on('change',function(){
                data['dog_name'] = $(this).val();
            })
        }
        if(count===7){
            v1 = $("#inputer").val();
            v2 = $("#quest").text("QUESTION " + q + "/"+tot);
            $("#th").text("What’s Breed is "+data['dog_name']);
            p1=$("<p></p>").text("If you’re not sure, just select unknown or mixed breed (the love’s the same).");
            $("#th").append(p1);
            inp='<div class="row justify-content-center mt-5">\n' +
                '  <div class="col-md-8">\n' +
                '<input type="text" class="form-control" autofocus placeholder="Start Typing" list="datalistOptions2" required/>\n' +
                ' </div>\n' +
                '</div>';
            $("#th").append(inp);
        }
        if(count===8){
            q--;
            v2 = $("#quest").text("");
            $("#th").text("Affenpinscher! One of our favorites!");
            p1=$("<p class='my-4'></p>").text("We'll draw from our vet experts and data insights to tailor our treats based on the rest of their profile. Just a few more Q's and you're outta here");
            $("#th").append(p1);
            $("#next-btn").html("Continue");
        }
        if(count===9){
            v2 = $("#quest").text("QUESTION " + q + "/"+tot);
            $("#th").text(data['dog_name']+" is a");
            var radio1='<div class="form-group mt-3">' +
                '            <input type="radio" name="gender" class="form-check-input" value="0"/>' +
                '            <label>Good Boy</label>' +
                '            <input type="radio" name="gender" class="form-check-input" value="1"/>' +
                '            <label>Good Girl</label>' +
                '        </div>';
            $("#th").append(radio1);
            $('input[type=radio][name=gender]').change(function () {
                data[($(this).attr('name'))] = $(this).val();

            })
        }
        if(count===10){
            v2 = $("#quest").text("QUESTION " + q + "/"+tot);
            v3=parseInt($("input[name='gender']:checked").val());
            if(v3===0){
                genderLabel="He";
            }
            else if(v3===1){
                genderLabel="She";
            }
            var text = genderLabel === "He" ? "neutered":"spayed"
            $("#th").text("is "+genderLabel+" "+text);
            var radio1=genderLabel === "He" ? '<div class="form-group mt-3">' +
                '            <input type="radio" name="neutered" class="form-check-input" value="1"/>' +
                '            <label>Yes</label>' +
                '            <input type="radio" name="neutered" class="form-check-input" value="0"/>' +
                '            <label>No</label>' +
                '        </div>' :'<div class="form-group mt-3">' +
                '            <input type="radio" name="spayed" class="form-check-input" value="1"/>' +
                '            <label>Yes</label>' +
                '            <input type="radio" name="spayed" class="form-check-input" value="0"/>' +
                '            <label>No</label>' +
                '        </div>';
            $("#th").append(radio1);

            if(genderLabel === "He"){
                $('input[type=radio][name=neutered]').change(function () {
                    data[$(this).attr('name')] = $(this).val();
                })
            }else{
                $('input[type=radio][name=spayed]').change(function () {
                    data[$(this).attr('name')] = $(this).val();
                })
            }

        }
        if(count===11) {
            v2 = $("#quest").text("QUESTION " + q + "/"+tot);
            $("#th").text("When is " + data['dog_name'] + " Birthday");
            p1 = $("<p style='mt-3 mb-5 pb-3'></p>").text("If you don’t know the exact date, just guesstimate. Everyone celebrates differently.");
            $("#th").append(p1);

            var years = '';
            for(var year = 2021;year > 1990;year--){
                years +='<option value='+year+' >'+year+'</option>'
            }
            var months = '';
            for(var month = 1 ; month <=12;month++){

                var temp = month < 10 ? '0'+month:month;
                months +='<option value='+month+' >'+temp+'</option>'
            }
            var select = '<select name="birthday_month" class="input-select b-select month"><option value="" disabled="" selected="">Month</option>'+months+'</select>'+
                '<select  name="birthday_year" class="input-select b-select year"><option value="" disabled="" selected="">Year</option>'+years+'</select>';
            $("#th").append(select);
            $("#next-btn").html("Next");

            $('select[name=birthday_year]').on('change',function () {
                const value = $(this).find(':selected').val();
                data['birthday_year'] = value;
            });
            $('select[name=birthday_month]').on('change',function () {
                const value = $(this).find(':selected').val();
                data['birthday_month'] = value;
            })
        }
        if(count===12){
            v2 = $("#quest").text("");
            q--;
            var year=parseInt(data['birthday_year']);
            let para = '';
            if(year<=2013){
                $("#th").text("A senior pup!");
                para = 'Fun fact: We did a study and it said Seniors make your life 10000% better. We’ll select some treats that’ll have her feeling young again.';
            }
            else if(year<=2019){
                let gender = parseInt(data['gender']);
                if(gender === 0){
                    $("#th").text('In her prime')
                }else{
                    $("#th").text('In his prime')
                }
                para = 'Your pup is settled in and ready to take on the world (if puppy hasnt already). We’ll curate some treats that help her thrive from now till puppy\'s a senior!'
            }
            else{
                $("#th").text("Still a puppy!");
                para = 'Don’t forget to keep up with your training and socializing. We’ll select some treats that help her grow up strong, healthy, and smart.';
            }
            p1 = $("<p style='mt-3 mb-5 pb-3'></p>").text(para);
            $("#th").append(p1);
            $("#next-btn").html("Continue");
        }
        if(count===13){
            v2 = $("#quest").text("QUESTION " + q + "/"+tot);
            $("#th").text("How much does "+v1+" weigh?");
            p1=$("<p></p>").text("We use their weight to personalize the appropriate dosage of Dandy for your pup!");
            $("#th").append(p1);
            inp='<div class="row justify-content-center mt-5">' +
                '            <div class="col-md-8">' +
                '                <input type="text" class="form-control" id="inputer" name="weight" placeholder="lb" autofocus required/>' +
                '            </div>' +
                '        </div>';
            $("#th").append(inp);
            $('input[type=text][name=weight]').on('change',function(){
                data['weight'] = $(this).val();
            })
            $("#next-btn").html("Next");
        }
        if(count===14){
            v2 = $("#quest").text("QUESTION " + q + "/"+tot);
            $("#th").text("How much exercise does "+v1+" get on a typical day?");
            $("#inputer").remove();
            var radio1='<div class="form-group my-3">' +
                '            <input type="radio" name="exercise_frequently" value="229" class="form-check-input"/>' +
                '            <label>Minimal</label>' +
                '            <input type="radio" name="exercise_frequently" value="230" class="form-check-input"/>' +
                '            <label>About An Hour</label>' +
                '            <input type="radio" name="exercise_frequently" value="231" class="form-check-input"/>' +
                '            <label>2 Hours</label>' +
                '        </div>';
            $("#th").append(radio1);
            $("#next-btn").html("Next");

            $('input[type=radio][name=exercise_frequently]').change(function () {
                data['exercise_frequently'] = $(this).val();
            })
        }
        if(count===15){
            v2 = $("#quest").text("QUESTION " + q + "/"+tot);
            $("#th").text("On average, how energetic is  "+v1);
            var radio1='<div class="form-group my-3">' +
                '            <input type="radio" name="energetic" value="232" class="form-check-input"/>' +
                '            <label>A couch</label>' +
                '            <input type="radio" name="energetic" value="233" class="form-check-input"/>' +
                '            <label>A Few</label>' +
                '            <input type="radio" name="energetic" value="234" class="form-check-input"/>' +
                '            <label>As Hype</label>' +
                '        </div>';
            $("#th").append(radio1);
            $("#next-btn").html("Next");
            $('input[type=radio][name=energetic]').change(function () {
                data['energetic'] = $(this).val();
            })
        }
        if(count===16){
            v2 = $("#quest").text("QUESTION " + q + "/"+tot);
            $("#th").text("What’s"+v1+"'s"+" daily diet?");
            var check_box='<div class="check-box-option">\n' +
                '        <div class="row justify-content-center">\n' +
                '            <div class="col-md-3">\n' +
                '                <label>\n' +
                '                    <input type="checkbox" name="foods" value="235"/>\n' +
                '                    <span onclick="changeValue('+"'foods'"+',235,true)">Dry Kibble</span>\n' +
                '                </label>\n' +
                '            </div>\n' +
                '            <div class="col-md-3">\n' +
                '                <label>\n' +
                '                    <input type="checkbox" name="foods" value="236"/>\n' +
                '                    <span onclick="changeValue('+"'foods'"+',236,true)">Grain-Free Kibble</span>\n' +
                '                </label>\n' +
                '            </div>\n' +
                '            <div class="col-md-3">\n' +
                '                <label>\n' +
                '                    <input type="checkbox" name="foods" value="237"/>\n' +
                '                    <span onclick="changeValue('+"'foods'"+',237,true)">Raw</span>\n' +
                '                </label>\n' +
                '            </div>\n' +
                '            <div class="col-md-3">\n' +
                '                <label>\n' +
                '                    <input type="checkbox" name="foods" value="238"/>\n' +
                '                    <span onclick="changeValue('+"'foods'"+',238,true)">Home-Cooked</span>\n' +
                '                </label>\n' +
                '            </div>\n' +
                '            <div class="col-md-3">\n' +
                '                <label>\n' +
                '                    <input type="checkbox" name="foods" value="239"/>\n' +
                '                    <span onclick="changeValue('+"'foods'"+',239,true)">Canned</span>\n' +
                '                </label>\n' +
                '            </div>\n' +
                '            <div class="col-md-3">\n' +
                '                <label>\n' +
                '                    <input type="checkbox" name="foods" value="240"/>\n' +
                '                    <span onclick="changeValue('+"'foods'"+',240,true)">Other</span>\n' +
                '                </label>\n' +
                '            </div>\n' +
                '        </div>\n' +
                '    </div>';
            inp='<div class="row justify-content-center">' +
                '            <div class="col-md-8">' +
                '                <input type="text" class="form-control" id="inputer" name="other_food" placeholder="Other" autofocus required/>' +
                '            </div>' +
                '        </div>';
            $("#th").append(check_box);

            $("#th").append(inp);
            $('input[type=text][name=other_food]').on('change',function () {
                data['foods'].other = $(this).val();
            })
        }

        if(count===17){
            v2 = $("#quest").text("QUESTION " + q + "/"+tot);
            $("#th").text("Does "+v1+" have any food allergies?");
            var radio1='<div class="form-group my-3">' +
                '            <input type="radio" name="is_food_allergies" value="241" class="form-check-input"/>' +
                '            <label>Yes</label>' +
                '            <input type="radio" name="is_food_allergies" value="242" class="form-check-input"/>' +
                '            <label>No</label>' +
                '            <input type="radio" name="is_food_allergies" value="243" class="form-check-input"/>' +
                '            <label>I don\'t know</label>' +
                '        </div>';
            $("#th").append(radio1);
            $("#next-btn").html("Next");
            $('input[type=radio][name=is_food_allergies]').change(function () {
                data['is_food_allergies'] = $(this).val();
                if($(this).val()==242){
                    count++;
                    q++;
                }
                if($(this).val()==243){
                    count++;
                    q++;
                }
            })
        }
        if(count===18){
            v2 = $("#quest").text("QUESTION " + q + "/"+tot);
            $("#th").text("Select all "+v1+" food allergies");
            var check_box='<div class="check-box-option">\n' +
                '        <div class="row justify-content-center">\n' +
                '            <div class="col-md-3">\n' +
                '                <label>\n' +
                '                    <input type="checkbox" name="food_allergies" value="244"/>\n' +
                '                    <span onclick="changeValue('+"'anxious'"+',762,true)">Beef</span>\n' +
                '                </label>\n' +
                '            </div>\n' +
                '            <div class="col-md-3">\n' +
                '                <label>\n' +
                '                    <input type="checkbox" name="food_allergies" value="245"/>\n' +
                '                    <span onclick="changeValue('+"'anxious'"+',763,true)">Dairy</span>\n' +
                '                </label>\n' +
                '            </div>\n' +
                '            <div class="col-md-3">\n' +
                '                <label>\n' +
                '                    <input type="checkbox" name="food_allergies" value="246"/>\n' +
                '                    <span onclick="changeValue('+"'anxious'"+',764,true)">Soy</span>\n' +
                '                </label>\n' +
                '            </div>\n' +
                '            <div class="col-md-3">\n' +
                '                <label>\n' +
                '                    <input type="checkbox" name="food_allergies" value="247"/>\n' +
                '                    <span onclick="changeValue('+"'anxious'"+',765,true)">Wheat/Grains</span>\n' +
                '                </label>\n' +
                '            </div>\n' +
                '            <div class="col-md-3">\n' +
                '                <label>\n' +
                '                    <input type="checkbox" name="food_allergies" value="248"/>\n' +
                '                    <span onclick="changeValue('+"'anxious'"+',766,true)">Egg</span>\n' +
                '                </label>\n' +
                '            </div>\n' +
                '            <div class="col-md-3">\n' +
                '                <label>\n' +
                '                    <input type="checkbox" name="food_allergies" value="249"/>\n' +
                '                    <span onclick="changeValue('+"'anxious'"+',767,true)">Chicken</span>\n' +
                '                </label>\n' +
                '        </div>\n' +
                '            <div class="col-md-3">\n' +
                '                <label>\n' +
                '                    <input type="checkbox" name="food_allergies" value="250"/>\n' +
                '                    <span onclick="changeValue('+"'anxious'"+',767,true)">Fish</span>\n' +
                '                </label>\n'+
                '        </div>\n' +
                '            <div class="col-md-3">\n' +
                '                <label>\n' +
                '                    <input type="checkbox" name="food_allergies" value="251"/>\n' +
                '                    <span onclick="changeValue('+"'anxious'"+',767,true)">Other</span>\n' +
                '                </label>\n'+
                '            </div>\n' +
                '        </div>\n' +
                '    </div>';
            inp='<div class="row justify-content-center">' +
                '            <div class="col-md-8">' +
                '                <input type="text" class="form-control" id="inputer" name="other_anxious" placeholder="Other" autofocus required/>' +
                '            </div>' +
                '        </div>';
            $("#th").append(check_box);
            $("#th").append(inp);
        }
        if(count===19){
            v2 = $("#quest").text("QUESTION " + q + "/"+tot);
            $("#th").text("Does "+v1+" have any environmental allergies?");
            var radio1='<div class="form-group my-3">' +
                '            <input type="radio" name="is_environment_allergies" value="251" class="form-check-input"/>' +
                '            <label>Yes</label>' +
                '            <input type="radio" name="is_environment_allergies" value="252" class="form-check-input"/>' +
                '            <label>No</label>' +
                '            <input type="radio" name="is_environment_allergies" value="253" class="form-check-input"/>' +
                '            <label>I don\'t know</label>' +
                '        </div>';
            $("#th").append(radio1);
            $('input[type=radio][name=is_environment_allergies]').change(function () {
                data['is_environment_allergies'] = $(this).val();
                if($(this).val==252){
                        count++;
                        q++;
                }
                if($(this).val()==253){
                    count++;
                    q++;
                }
            })
        }
        if(count===20){
            v2 = $("#quest").text("QUESTION " + q + "/"+tot);
            $("#th").text("Select all "+v1+ " environmental allergies");
            var check_box='<div class="check-box-option">\n' +
                '        <div class="row justify-content-center">\n' +
                '            <div class="col-md-3">\n' +
                '                <label>\n' +
                '                    <input type="checkbox" name="foods" value="762"/>\n' +
                '                    <span onclick="changeValue('+"'anxious'"+',762,true)">Mold</span>\n' +
                '                </label>\n' +
                '            </div>\n' +
                '            <div class="col-md-3">\n' +
                '                <label>\n' +
                '                    <input type="checkbox" name="foods" value="763"/>\n' +
                '                    <span onclick="changeValue('+"'anxious'"+',763,true)">Dust</span>\n' +
                '                </label>\n' +
                '            </div>\n' +
                '            <div class="col-md-3">\n' +
                '                <label>\n' +
                '                    <input type="checkbox" name="foods" value="764"/>\n' +
                '                    <span onclick="changeValue('+"'anxious'"+',764,true)">Pollen</span>\n' +
                '                </label>\n' +
                '            </div>\n' +
                '            <div class="col-md-3">\n' +
                '                <label>\n' +
                '                    <input type="checkbox" name="foods" value="765"/>\n' +
                '                    <span onclick="changeValue('+"'anxious'"+',765,true)">Grass</span>\n' +
                '                </label>\n' +
                '            </div>\n' +
                '            <div class="col-md-3">\n' +
                '                <label>\n' +
                '                    <input type="checkbox" name="foods" value="766"/>\n' +
                '                    <span onclick="changeValue('+"'anxious'"+',766,true)">Cedar</span>\n' +
                '                </label>\n' +
                '            </div>\n' +
                '            <div class="col-md-3">\n' +
                '                <label>\n' +
                '                    <input type="checkbox" name="foods" value="767"/>\n' +
                '                    <span onclick="changeValue('+"'anxious'"+',767,true)">Other</span>\n' +
                '                </label>\n' +
                '            </div>\n' +
                '        </div>\n' +
                '    </div>';
            inp='<div class="row justify-content-center">' +
                '            <div class="col-md-8">' +
                '                <input type="text" class="form-control" id="inputer" name="other_anxious" placeholder="Other" autofocus required/>' +
                '            </div>' +
                '        </div>';
            $("#th").append(check_box);
            $("#th").append(inp);
        }
        if(count===21){
            v2 = $("#quest").text("QUESTION " + q + "/"+tot);
            $("#th").text(v1+" gets anxious when...?");
            para='<p>Select all that apply<p>';
            $("#th").append(para);
            var check_box='<div class="check-box-option">\n' +
                '        <div class="row justify-content-center">\n' +
                '            <div class="col-md-3">\n' +
                '                <label>\n' +
                '                    <input type="checkbox" name="anxious" value="762"/>\n' +
                '                    <span onclick="changeValue('+"'anxious'"+',762,true)">Alone</span>\n' +
                '                </label>\n' +
                '            </div>\n' +
                '            <div class="col-md-3">\n' +
                '                <label>\n' +
                '                    <input type="checkbox" name="anxious" value="763"/>\n' +
                '                    <span onclick="changeValue('+"'anxious'"+',763,true)">Strange sounds</span>\n' +
                '                </label>\n' +
                '            </div>\n' +
                '            <div class="col-md-3">\n' +
                '                <label>\n' +
                '                    <input type="checkbox" name="anxious" value="764"/>\n' +
                '                    <span onclick="changeValue('+"'anxious'"+',764,true)">With new people</span>\n' +
                '                </label>\n' +
                '            </div>\n' +
                '            <div class="col-md-3">\n' +
                '                <label>\n' +
                '                    <input type="checkbox" name="anxious" value="765"/>\n' +
                '                    <span onclick="changeValue('+"'anxious'"+',765,true)">Around dogs</span>\n' +
                '                </label>\n' +
                '            </div>\n' +
                '            <div class="col-md-3">\n' +
                '                <label>\n' +
                '                    <input type="checkbox" name="anxious" value="766"/>\n' +
                '                    <span onclick="changeValue('+"'anxious'"+',766,true)">Not anxious!</span>\n' +
                '                </label>\n' +
                '            </div>\n' +
                '            <div class="col-md-3">\n' +
                '                <label>\n' +
                '                    <input type="checkbox" name="anxious" value="767"/>\n' +
                '                    <span onclick="changeValue('+"'anxious'"+',767,true)">Other</span>\n' +
                '                </label>\n' +
                '            </div>\n' +
                '        </div>\n' +
                '    </div>';
            inp='<div class="row justify-content-center">' +
                '            <div class="col-md-8">' +
                '                <input type="text" class="form-control" id="inputer" name="other_anxious" placeholder="Other" autofocus required/>' +
                '            </div>' +
                '        </div>';
            $("#th").append(check_box);
            $("#th").append(inp);
            $('input[type=text][name=other_anxious]').on('change',function () {
                data['anxious'].other = $(this).val();
            })
        }

        if(count===22){
            v2 = $("#quest").text("QUESTION " + q + "/"+tot);
            $("#th").text("Does "+v1+" have any medical conditions?");
            var radio1='<div class="form-group my-3">' +
                '            <input type="radio" name="is_medical_condition" value="262" class="form-check-input"/>' +
                '            <label>Yes</label>' +
                '            <input type="radio" name="is_medical_condition" value="263" class="form-check-input"/>' +
                '            <label>No</label>' +
                '            <input type="radio" name="is_medical_condition" value="264" class="form-check-input"/>' +
                '            <label>I don\'t know</label>' +
                '        </div>';
            $("#th").append(radio1);
            $('input[type=radio][name=is_medical_condition]').change(function () {
                data['is_medical_condition'] = $(this).val();
                if($(this).val()==263){
                    count+=2;
                    q+=2;
                }
                if($(this).val()==264){
                    count+=2;
                    q+=2;
                }
            })
        }
        if(count===23){
            v2 = $("#quest").text("QUESTION " + q + "/"+tot);
            $("#th").text("What Are "+v1+" Medical Issues?");
            var para=('<p>Dandy recommends consulting with your vet before starting your dog on any supplements before, during or after treatment or surgery.</p>');
            $("#th").append(para);
            var check_box='<div class="check-box-option">\n' +
                '        <div class="row justify-content-center">\n' +
                '            <div class="col-md-3">\n' +
                '                <label>\n' +
                '                    <input type="checkbox" name="medical_issues" value="265"/>\n' +
                '                    <span onclick="changeValue('+"'anxious'"+',265,true)">Arthritis</span>\n' +
                '                </label>\n' +
                '            </div>\n' +
                '            <div class="col-md-3">\n' +
                '                <label>\n' +
                '                    <input type="checkbox" name="medical_issues" value="266"/>\n' +
                '                    <span onclick="changeValue('+"'anxious'"+',266,true)">Urinary Disease</span>\n' +
                '                </label>\n' +
                '            </div>\n' +
                '            <div class="col-md-3">\n' +
                '                <label>\n' +
                '                    <input type="checkbox" name="medical_issues" value="267"/>\n' +
                '                    <span onclick="changeValue('+"'anxious'"+',267,true)">Dental Disease</span>\n' +
                '                </label>\n' +
                '            </div>\n' +
                '            <div class="col-md-3">\n' +
                '                <label>\n' +
                '                    <input type="checkbox" name="medical_issues" value="268"/>\n' +
                '                    <span onclick="changeValue('+"'anxious'"+',268,true)">Cancer</span>\n' +
                '                </label>\n' +
                '            </div>\n' +
                '            <div class="col-md-3">\n' +
                '                <label>\n' +
                '                    <input type="checkbox" name="medical_issues" value="269"/>\n' +
                '                    <span onclick="changeValue('+"'anxious'"+',269,true)">Kidney Disease</span>\n' +
                '                </label>\n' +
                '            </div>\n' +
                '            <div class="col-md-3">\n' +
                '                <label>\n' +
                '                    <input type="checkbox" name="medical_issues" value="270"/>\n' +
                '                    <span onclick="changeValue('+"'anxious'"+',270,true)">Liver Disease</span>\n' +
                '                </label>\n' +
                '            </div>\n' +
                '            <div class="col-md-3">\n' +
                '                <label>\n' +
                '                    <input type="checkbox" name="medical_issues" value="271"/>\n' +
                '                    <span onclick="changeValue('+"'anxious'"+',271,true)">Heart disease</span>\n' +
                '                </label>\n' +
                '            </div>\n' +
                '            <div class="col-md-3">\n' +
                '                <label>\n' +
                '                    <input type="checkbox" name="medical_issues" value="272"/>\n' +
                '                    <span onclick="changeValue('+"'anxious'"+',272,true)">Diabetes</span>\n' +
                '                </label>\n' +
                '            </div>\n' +
                '            <div class="col-md-3">\n' +
                '                <label>\n' +
                '                    <input type="checkbox" name="medical_issues" value="273"/>\n' +
                '                    <span onclick="changeValue('+"'anxious'"+',273,true)">Other</span>\n' +
                '                </label>\n' +
                '            </div>\n' +
                '        </div>\n' +
                '    </div>';
            inp='<div class="row justify-content-center">' +
                '            <div class="col-md-8">' +
                '                <input type="text" class="form-control" id="inputer" name="other_anxious" placeholder="Other" autofocus required/>' +
                '            </div>' +
                '        </div>';
            $("#th").append(check_box);
            $("#th").append(inp);
        }
        if(count===24){
            v2=$('#quest').text("QUESTION "+q+"/"+tot);
            $("#th").text("Tell us what medication they are on, if any.");
            inp='<div class="row justify-content-center">' +
                '            <div class="col-md-8">' +
                '                <input type="text" class="form-control" id="inputer" name="other_anxious" autofocus required/>' +
                '            </div>' +
                '        </div>';
            $("#th").append(inp);
        }
        if(count===25){
            v2 = $("#quest").text("QUESTION " + q + "/"+tot);
            $("#th").text(v1+" daily diet?");
            var check_box='<div class="check-box-option">\n' +
                '        <div class="row justify-content-center">\n' +
                '            <div class="col-md-3">\n' +
                '                <label>\n' +
                '                    <input type="checkbox" name="need_support" value="285"/>\n' +
                '                    <span>Anxiety / Stress</span>\n' +
                '                </label>\n' +
                '            </div>\n' +
                '            <div class="col-md-3">\n' +
                '                <label>\n' +
                '                    <input type="checkbox" name="need_support" value="284"/>\n' +
                '                    <span>Hip / Joint</span>\n' +
                '                </label>\n' +
                '            </div>\n' +
                '            <div class="col-md-3">\n' +
                '                <label>\n' +
                '                    <input type="checkbox" name="need_support" value="288"/>\n' +
                '                    <span>Energy</span>\n' +
                '                </label>\n' +
                '            </div>\n' +
                '            <div class="col-md-3">\n' +
                '                <label>\n' +
                '                    <input type="checkbox" name="need_support" value="286"/>\n' +
                '                    <span>Allergies</span>\n' +
                '                </label>\n' +
                '            </div>\n' +
                '            <div class="col-md-3">\n' +
                '                <label>\n' +
                '                    <input type="checkbox" name="need_support" value="290"/>\n' +
                '                    <span>Eye health</span>\n' +
                '                </label>\n' +
                '            </div>\n' +
                '            <div class="col-md-3">\n' +
                '                <label>\n' +
                '                    <input type="checkbox" name="need_support" value="292"/>\n' +
                '                    <span>Liver health</span>\n' +
                '                </label>\n' +
                '            </div>\n' +
                '            <div class="col-md-3">\n' +
                '                <label>\n' +
                '                    <input type="checkbox" name="need_support" value="293"/>\n' +
                '                    <span>Skin / Coat</span>\n' +
                '                </label>\n' +
                '            </div>\n' +
                '            <div class="col-md-3">\n' +
                '                <label>\n' +
                '                    <input type="checkbox" name="need_support" value="294"/>\n' +
                '                    <span>Thyroid</span>\n' +
                '                </label>\n' +
                '            </div>\n' +
                '            <div class="col-md-3">\n' +
                '                <label>\n' +
                '                    <input type="checkbox" name="need_support" value="283"/>\n' +
                '                    <span>Overall wellness</span>\n' +
                '                </label>\n' +
                '            </div>\n' +
                '            <div class="col-md-3">\n' +
                '                <label>\n' +
                '                    <input type="checkbox" name="need_support" value="287"/>\n' +
                '                    <span>Sleep</span>\n' +
                '                </label>\n' +
                '            </div>\n' +
                '            <div class="col-md-3">\n' +
                '                <label>\n' +
                '                    <input type="checkbox" name="need_support" value="289"/>\n' +
                '                    <span>Chronic Pain</span>\n' +
                '                </label>\n' +
                '            </div>\n' +
                '            <div class="col-md-3">\n' +
                '                <label>\n' +
                '                    <input type="checkbox" name="need_support" value="291"/>\n' +
                '                    <span>Heart health</span>\n' +
                '                </label>\n' +
                '            </div>\n' +
                '            <div class="col-md-3">\n' +
                '                <label>\n' +
                '                    <input type="checkbox" name="need_support" value="301"/>\n' +
                '                    <span>Digestion</span>\n' +
                '                </label>\n' +
                '            </div>\n' +
                '        </div>\n' +
                '    </div>';
            inp='<div class="row justify-content-center">' +
                '            <div class="col-md-8">' +
                '                <input type="text" class="form-control" id="inputer" name="weight" placeholder="Other" autofocus required/>' +
                '            </div>' +
                '        </div>';
            $("#th").append(check_box);
            $("#th").append(inp);
        }
    }

    $(document).ready(function (){

        $("#next-btn").on('click',function (){
            renderQuestion();

        });


    });
    // renderQuestion(16);
</script>
</body>
</html>
