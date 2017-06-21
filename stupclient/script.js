// начинает работать после выбора файла
function StupFileOnchange(event) {

	var StupForm = document.getElementById('stup_form');
	var StupFile = document.getElementById('stup_file');
    var StupFormData = new FormData(StupForm);
    var XHR = new XMLHttpRequest();        

	StupFormData.append("stup_param", "Параметр из скрипта");
		    
    XHR.upload.addEventListener('progress', StupProgress, false);
    XHR.addEventListener('load', StupFinish, false);
    XHR.addEventListener('error', StupError, false);
    XHR.addEventListener('abort', StupAbort, false);
    XHR.open('POST', SERVERHANDLER,true);
    XHR.send(StupFormData);

}

// массив выводит в виде таблицы
function arr2table(arr, divId){
	var div, tab, tr, td, th;
	var key, a, k;

	tab = document.createElement('table');

	for (key in arr) {
		a=arr[key];
		if(key==0) {
			tr = document.createElement('tr');
			for (k in a) {
				th = document.createElement('th');
				th.innerHTML = k;
				tr.appendChild(th);
			}
		tab.appendChild(tr);
		}
		tr = document.createElement('tr');
		for (k in a) {
			td = document.createElement('td');
			td.innerHTML = a[k];
			tr.appendChild(td);
		}
	tab.appendChild(tr);
	}  

	div = document.getElementById(divId);
	div.appendChild(tab);	
}

// изменение полоски во время загрузки
function StupProgress(event) {
	var iPercentComplete = Math.round(event.loaded * 100 / event.total);
	document.getElementById('stup_progress').style.width = iPercentComplete.toString() + '%';	
}
// по окончанию загрузки выдает ответ-отчет о загрузке
function StupFinish(event) {
    var response=JSON.parse(event.target.responseText);
    
	var duration=1000*parseFloat(getComputedStyle(stup_fader)['transitionDuration']);
	if(stup_message.innerHTML=='') {
		StupUpdateAnime(response);
		stup_fader.style.opacity = "0";
	}
	else {
		stup_fader.style.opacity = "1";
		setTimeout(StupUpdateAnime, duration, response);
		setTimeout('stup_fader.style.opacity = "0"', duration, response);
	}
	
    StupShowFiles();
}

function StupUpdateAnime(response) {	
	stup_message.innerHTML='';	
	arr2table(response['files'], 'stup_message');	// выдача списка мзагруженных файлов
    stup_output.innerHTML = response['output'];		// выдача остального текста из stupserver.php
}

function StupError(event) {
	alert("Во время загрузки произошла ошибка");
}

function StupAbort(event) {
	alert("Загрузка отменена");
}


// посылает запрос к showfiles.php для проверки
function StupShowFiles() {
    var XHR = new XMLHttpRequest(); 
    XHR.addEventListener('load', StupShowFilesOnLoad, false);
    XHR.open('GET', SHOWFILESHANDLER,true);
    XHR.send();
}
// вывод всех файлов. (те, что уже были, и добавленные)
function StupShowFilesOnLoad(event) {
	document.getElementById('stup_showfiles').innerHTML = "Файлы на сайте: "+event.target.responseText;
}

