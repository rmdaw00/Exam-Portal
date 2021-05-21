<?php function answerToAlpabet($answer) {
    switch($answer){
        case 1:
            return "A";
            break;
        case 2:
            return "B";
            break;
        case 3:
            return "C";
            break;
        case 4:
            return "D";
            break;
    }
}

function questionToHTML($qid,$marks,$text,$option1,$option2,$option3,$option4,$answer) {
        

        return '<div class="examQuestion">
                    <div class="marksLabel">'
                        . $marks. ($marks==1?' Mark':' Marks') . ' 
                    </div>
                    <div class="question">
                        <p>'. $text .'</p>
                    </div>
                    <div class="question">
                        <input type="radio" name="a'. $qid .'" value="1" ' . ($answer==1?'checked':'') . ($answer!=0?' disabled':'') .'/>
                        <span>'. $option1 .' </span>
                    </div>
                    <div class="question">
                        <input type="radio" name="a'. $qid .'" value="2" ' . ($answer==2?'checked':'') . ($answer!=0?' disabled':'').'/>
                        <span>'. $option2 .' </span>
                    </div>'. 
                    (!empty($option3)?'<div class="question"><input type="radio" name="a'. $qid .'" value="3" ' . ($answer==3?'checked':'') . ($answer!=0?' disabled':'') .'/><span>'. $option3 .' </span></div>':'') .
                    (!empty($option4)?'<div class="question"><input type="radio" name="a'. $qid .'" value="4" ' . ($answer==4?'checked':'') . ($answer!=0?' disabled':'') .'/><span>'. $option4 .' </span></div>':'') .
              '</div>';
}
?>

