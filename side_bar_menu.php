<?php

function side_bar()
{
	$bar = '<li><a href="MakeQuestion.php"><i class="fas fa-edit fa-2x" aria-hidden="true"></i> 出題 </a></li>
			<li><a href="KeyboardSite.php"><i class="fas fa-grip-horizontal fa-2x" aria-hidden="true"></i> Keyboard題型 </a></li>
            <li><a href="QuestionList.php"><i class="fas fa-book fa-2x" aria-hidden="true"></i> 題庫 </a></li>
    	    <li><a href="ExamList.php"><i class="fas fa-list-ol fa-2x" aria-hidden="true"></i> 測驗卷 </a></li>
            <li><a href="ExamHistory.php"><i class="fas fa-list-ol fa-2x" aria-hidden="true"></i> 考試紀錄 </a></li>
            <li><a href="SignUpStudent.php"><i class="fas fa-user-plus fa-2x" aria-hidden="true"></i> 新學生註冊 </a></li>
            <li><a href="StudentList.php"><i class="fas fa-school fa-2x" aria-hidden="true"></i> 學生清單 </a></li>
            <li><a href="logout.php"><i class="fas fa-arrow-alt-circle-left fa-2x" aria-hidden="true"></i> 登出 </a></li>';
	return $bar;
}

?>