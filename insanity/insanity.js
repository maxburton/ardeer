var timer = 1000;
var answerdelay = 250;
var questionActive = false;
var answer = -1;
var difficulty = 0;
var points = 0;
var maxPoints = 3*3 + 3*6 + 4*9;
var round = 1;
var totalRounds = 10;

/* Format: Outer array- Difficulty, Inner Array- Question*/
var questions = [[
	/* Difficulty 0 */
	{question:"Name a colour of the rainbow",
	wrong:["cyan", "pink", "teal", "coral", "maroon", "lilac", "black", "white", "grey", "brown"],
	right:["red", "orange", "yellow", "green", "blue", "indigo", "violet"]
	},
	{question:"Name a poker hand",
	wrong:["royal straight", "double flush", "five of a kind", "half house", "high queen", "aces high", "blackjack", "monty", "big kahuna", "back straight"],
	right:["full house", "royal flush", "straight", "high card", "two pair", "four of a kind"]
	},
	{question:"Name a european country",
	wrong:["china", "london", "georgia", "azerbaijan", "dubai", "isle of man", "jersey", "portufrance", "cyka blyatican", "moscow"],
	right:["czech republic", "malta", "denmark", "montenegro", "algeria", "greece"]
	},
	],[ 
	/* Difficulty 1 */
	{question:"Name an olympic sport",
	wrong:["hexathlon", "decathlon", "swordfighting", "squash", "beekeeping", "motor racing", "600m", "16000m", "pole jump", "pommel"],
	right:["football", "ping pong", "equestrian", "snowboarding", "luge", "polo", "biathlon"]
	},
	{question:"Name a football team",
	wrong:["oxford rovers", "london park rangers", "lapaz fc", "miami mile high", "dresdon warriors", "ccr", "real santiago", "helmsquay", "big spirit shanghai", "shlakee 07"],
	right:["wolves", "nottingham forest", "kaiser chiefs", "qpr", "sheffield wednesday", "old boys basel"]
	},
	{question:"Name a fake word",
	wrong:["aa", "apoptosis", "croze", "eyewater", "howff", "illywhacker", "momism", "nainsook", "resurrection man", "sarmie"],
	right:["willywhacker", "erection man", "bahooch", "bumbalina", "spudulike", "crankle"]
	},
	],[
	/* Difficulty 2 */
	{question:"Name a Jedward song",
	wrong:["lithium", "tell me your number", "under cheshire", "oh wow", "everyday allstar", "good vibrations", "in the dark", "hold me closer", "unstoppable", "techno babe"],
	right:["put the green cape on", "free spirit", "luminous", "young love", "cant forget you", "pop rocket", "my miss america", "oh hell no"]
	},
	{question:"Name a simpsons character",
	wrong:["frank wiggum", "donnie darko", "simon muntz", "duffguy", "chip", "paddy cloverface", "fishy the fish", "shelb e vil", "mr snrub", "abe van houten"],
	right:["uter", "edna", "bumblebee man", "kent brockman", "herschel krustofsky", "martin prince"]
	},
	{question:"Name a ben n jerry's ice cream flavour",
	wrong:["chocolate delight", "strawberry cream", "thin mint", "cookiepalooza", "extra chocolate", "mallow dream", "ginger n lime", "sorbest", "sweet n sour"],
	right:["chunky monkey", "americone dream", "buzzbuzzbuzz", "totally baked", "phish food", "caramel blondie"]
	},
	{question:"Name a quentin tarantino character",
	wrong:["henry coppa", "vernon gage", "black serpent", "rocco", "miranda", "jacko", "giles wallace", "vinnie vague", "harry kane"],
	right:["jules winnfield", "jimmy", "beatrix kiddo", "bill", "hans landa", "aldo raine", "daisy domergue", "zed"]
	},
	],
];
var questionsCopy = [questions[0].slice(),questions[1].slice(),questions[2].slice()];

function deepCopy(){
	
}

function getQuestion(){
	console.log(questions);
	console.log(questionsCopy);
	var index = Math.floor(Math.random() * questionsCopy[difficulty].length);
	var question = questionsCopy[difficulty][index];
	questionsCopy[difficulty].splice(index,1);
	var answers = [];
	var right = question.right[Math.floor(Math.random() * question.right.length)];
	var wrong = [];
	var wrongarray = question.wrong.slice();
	for(var i = 0; i < 3; i++){
		var index = Math.floor(Math.random() * wrongarray.length)
		wrong.push(wrongarray[index]);
		wrongarray.splice(index,1);
	}
	$("#question").text(question.question);
	$("#question").css("visibility", "visible");
	var rightanswer = Math.floor(Math.random() * 4);
	for(var i = 0; i < 4; i++){
		if(i == rightanswer){
			answers[i] = right;
		}else{
			answers[i] = wrong[0];
			wrong.splice(0,1);
		}
	}
	$("#answer1").text(answers[0]);
	$("#answer2").text(answers[1]);
	$("#answer3").text(answers[2]);
	$("#answer4").text(answers[3]);
	setTimeout(
		function() {
			questionActive = true;
			$("#answer1").css("visibility", "visible");
		}, answerdelay * 3);
	setTimeout(
		function() {
			$("#answer2").css("visibility", "visible");
		}, answerdelay * 4);
	setTimeout(
		function() {
			$("#answer3").css("visibility", "visible");
		}, answerdelay * 5);
	setTimeout(
		function() {
			$("#answer4").css("visibility", "visible");
		}, answerdelay * 6);
	setTimeout(
		function() {
			$("#timer").css("visibility", "visible");
			clockTick();
		}, answerdelay * 7);
		
	setTimeout(
			function() {
				questionActive = false;
				if(rightanswer == 0){
					$("#answer1").css("color", "green");
				}else if(rightanswer == 1){
					$("#answer2").css("color", "green");
				}else if(rightanswer == 2){
					$("#answer3").css("color", "green");
				}else if(rightanswer == 3){
					$("#answer4").css("color", "green");
				}
				if(rightanswer == answer){
					$("#result").text("Correct");
					$("#result").css("color", "green");
					points += (difficulty + 1) * 3;
					$("#info").text("Round " + round + " | Points: " + points);
				}else if(answer == -1){
					$("#result").text("Time's Up!");
					$("#result").css("color", "red");
				}else{
					$("#result").text("Wrong");
					$("#result").css("color", "red");
				}
				$("#result").css("visibility", "visible");
				answer = -1;
		}, answerdelay * 7 + 1000);
		
	setTimeout(
			function() {
				hideQuestion();
				round++;
				if(round > 3){
					difficulty = 1;
				}
				if(round > 6){
					difficulty = 2;
				}
				if(round <= totalRounds){
					$("#info").text("Round " + round + " | Points: " + points);
					getQuestion();
				}else{
					$("#info").hide();
					$("#start").show();
					$("#hint").text("You scored " + points + "/" + maxPoints + " points. " + pointsComment());
					$("#hint").show();
					questionsCopy = questionsCopy = [questions[0].slice(),questions[1].slice(),questions[2].slice()];
					difficulty = 0;
					points = 0;
					round = 1;
				}
		}, answerdelay * 7 + 3000);
}

function pointsComment(){
	var comment = "";
	if(points == maxPoints){
		comment = "Are you a genius?"
	}else if(points > maxPoints - (Math.floor(maxPoints/6))){
		comment = "Not bad."
	}else if(points > maxPoints - (Math.floor(2 * maxPoints/6))){
		comment = "Eh. It's ok I guess."
	}else if(points > maxPoints - (Math.floor(3 * maxPoints/6))){
		comment = "Painfully mediocre."
	}else if(points > maxPoints - (Math.floor(4 * maxPoints/6))){
		comment = "Yikes"
	}else if(points > maxPoints - (Math.floor(5 * maxPoints/6))){
		comment = "Were you dropped on your head as a child?"
	}else{
		comment = "A broom could answer more questions that you.";
	}
	return comment;
}

function hideQuestion(){
	$("#answer1").css("visibility", "hidden");
	$("#answer2").css("visibility", "hidden");
	$("#answer3").css("visibility", "hidden");
	$("#answer4").css("visibility", "hidden");
	blackify();
	$("#question").css("visibility", "hidden");
	$("#timer").css("visibility", "hidden");
	$("#result").css("visibility", "hidden");
}
function blackify(){
	$("#answer1").css("color", "black");
	$("#answer2").css("color", "black");
	$("#answer3").css("color", "black");
	$("#answer4").css("color", "black");
}

/* Animation for the clock ticking */
function clockTick(){
	var ms = 99;
	var pre = "00:00:"
	setTimeout(
		function() {
			clockText = "00:00:00"
			$("#timer").text(clockText);
	}, 1000);
	for(var i = 0; i < 32; i++){
		setTimeout(
			function() {
				ms = ms - 3;
				var clockText = pre + ms;
				$("#timer").text(clockText);
		}, 30 * i);
	}
	
}



$(document).ready(function(){
	$("#start").click(function(){
			$("#start").hide();
			$("#hint").hide();
			$("#info").text("Round 1 | Points: 0");
			$("#info").show();
			getQuestion();
	});
	$(document).keydown(function(e){
		if (e.keyCode > 36 && e.keyCode < 41){
			if(questionActive){
				blackify();
				if(e.keyCode == 37){
					answer = 1
					$("#answer2").css("color", "red");
				}
				if(e.keyCode == 38){
					answer = 0
					$("#answer1").css("color", "red");
				}
				if(e.keyCode == 39){
					answer = 2
					$("#answer3").css("color", "red");
				}
				if(e.keyCode == 40){
					answer = 3
					$("#answer4").css("color", "red");
				}
			}
		}
	});
	$(function(){
		$("#answer1").bind("click",function(){
			if(questionActive){
				blackify();
				answer = 0;
				$("#answer1").css("color", "red");
			}
		});
	});
	$(function(){
		$("#answer2").bind("click",function(){
			if(questionActive){
				blackify();
				answer = 1;
				$("#answer2").css("color", "red");
			}
		});
	});
	$(function(){
		$("#answer3").bind("click",function(){
			if(questionActive){
				blackify();
				answer = 2;
				$("#answer3").css("color", "red");
			}
		});
	});
	$(function(){
		$("#answer4").bind("click",function(){
			if(questionActive){
				blackify();
				answer = 3;
				$("#answer4").css("color", "red");
			}
		});
	});
});