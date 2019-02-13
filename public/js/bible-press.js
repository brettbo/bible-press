/* Bible-Press - Custom Login JavaScript */


function changeChapter(value) {
	console.log("changeChapter:  value=" + value);
	var count = getChapterCount(value);
	console.log("changeChapter:  chapter count=" + count);

	var selectList = document.getElementById("ch");
	console.log("changeChapter:  selectList=" + selectList);
	while (selectList.firstChild) {
   		selectList.removeChild(selectList.firstChild);
	}

	console.log("changeChapter:  selectList=" + selectList);

	for (var i = 1; i <= count; i++) {
	    var option = document.createElement("option");
	    option.value = i;
	    option.text = i;
	    selectList.appendChild(option);
	}
}

function getChapterCount(selected){
	// chapterCount is an array since the number of chapters in the Bible does not change
	var chapterCount = [50,40,27,36,34,24,21,4,31,24,22,25,29,36,10,13,10,42,150,31,12,8,66,52,5,48,12,14,3,9,1,4,7,3,3,3,2,14,4,28,16,24,21,28,16,16,13,6,6,4,4,5,3,6,4,3,1,13,5,5,3,5,1,1,1,22];
	var count = 0;
	var temp = "";
	console.log("getChapterCount:  selected=" + selected);
	temp = selected.toString();

	temp = selected.substr(0, 2);
	index = parseInt(temp, 10);
	index--;	//array is NOT zero based;
	console.log("getChapterCount:  index=" + index);
	count = chapterCount[index];
	
	return count;
}



// When the user hovers over the CrossRef, open the popup
function showCrossRef(elem) {
	console.log("showCrossRef:  id=" + elem.id);
	popuptext = "text-" + elem.id;	
  	var popup = document.getElementById(popuptext);
  	popup.classList.toggle("show");
}

// When the user leaves the CrossRef, hide the popup
function hideCrossRef(elem) {
	console.log("hideCrossRef:  id=" + elem.id);
	popuptext = "text-" + elem.id;	
  	var popup = document.getElementById(popuptext);
  	popup.classList.toggle("hide");
}

