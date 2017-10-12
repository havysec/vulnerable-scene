/*
Strip whitespace from the beginning and end of a string
Input : a string
*/
function trim(str)
{
	return str.replace(/^\s+|\s+$/g,'');
}

/*
Make sure that textBox only contain number
*/
function checkNumber(textBox)
{
	while (textBox.value.length > 0 && isNaN(textBox.value)) {
		textBox.value = textBox.value.substring(0, textBox.value.length - 1)
	}
	
	textBox.value = trim(textBox.value);
/*	if (textBox.value.length == 0) {
		textBox.value = 0;		
	} else {
		textBox.value = parseInt(textBox.value);
	}*/
}

/*
	Check if a form element is empty.
	If it is display an alert box and focus
	on the element
*/
function isEmpty(formElement, message) {
	formElement.value = trim(formElement.value);
	
	_isEmpty = false;
	if (formElement.value == '') {
		_isEmpty = true;
		alert(message);
		formElement.focus();
	}
	
	return _isEmpty;
}

/*
	Set one value in combo box as the selected value
*/
function setSelect(listElement, listValue)
{
	for (i=0; i < listElement.options.length; i++) {
		if (listElement.options[i].value == listValue)	{
			listElement.selectedIndex = i;
		}
	}	
}