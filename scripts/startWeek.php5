function addEvent(obj, type, fn) {
  if (obj.addEventListener) {
      obj.addEventListener(type, fn, false);
      } else {
        obj['e' + type + fn] = fn;
        obj[type + fn] = function(){obj['e' + type + fn](window.event); }
        obj.attachEvent('on'+ type, obj[type + fn]);
      }
  }

function listConfigs(str) {
if (str=="")
  {
  document.getElementById("todoform").innerHTML="No Configs";
  return;
  }
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("todoform").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","getConfigs.php5?user="+str,true);
xmlhttp.send();
}

function getRec(func, parms, destElm) {
if (func=="")  {
  document.getElementById(destElm).innerHTML="no form";
  return;
  }
if (window.XMLHttpRequest)  { // code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  } else  { // code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function() {
  if (xmlhttp.readyState==4 && xmlhttp.status==200) {
    document.getElementById(destElm).innerHTML=xmlhttp.responseText;
    f_tcalInit();
    if (func == 'formEmps') {
       addEeEvents();
       updEeTypeInfo();
       updDeptInfo();
    }
  }
}
xmlhttp.open("GET",func+".php5" +parms,true);
xmlhttp.send();
}

function getEeLine(emp,elm) {
if (emp=="")
  {
  document.getElementById(elm).innerHTML="no form";
  return;
  }
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById(elm).innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","getEeLine.php5?emplid="+emp,true);
xmlhttp.send();
}

function buildEd(tabName, funcName) {
if (tabName=="")
  {
  document.getElementById("todoform").innerHTML="no form";
  return;
  }
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("todoform").innerHTML=xmlhttp.responseText;
    document.getElementById("todostat").innerHTML = ' ';
    }
  }
xmlhttp.open("GET","buildEd.php5?table="+tabName+"&funcName="+funcName,true);
xmlhttp.send();
}

function get1(tabName, whereClause) {
if (whereClause=="")
  {
  document.getElementById("todoform").innerHTML="no form";
  return;
  }
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("todoform").innerHTML=xmlhttp.responseText;
    document.getElementById("todostat").innerHTML = ' ';
    }
  }
xmlhttp.open("GET","get1.php5?table="+tabName+"&where="+whereClause,true);
xmlhttp.send();
}

function get2(func, getParms, destElm) {
if (func=="") {
  document.getElementById(destElm).innerHTML="no function name";
  return;
  }
if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  } else {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)    {
    document.getElementById(destElm).innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET",func+".php5"+"?"+getParms,true);
xmlhttp.send();
}

function updDeptInfo(e) {
   var deptId = document.getElementById('deptId').value;
   var unitId = document.getElementById('unitId').value;
   get2("getDeptInfo","unitId="+unitId+"&deptId="+deptId,"deptInfo");
}

function updEeTypeInfo(e) {
   var eeType = document.getElementById('eeType').value;
   var unitId = document.getElementById('unitId').value;
   get2("getEeTypeInfo","unitId="+unitId+"&eeType="+eeType,"eeTypeInfo");
}

function addEeEvents() {
   addEvent(document.getElementById('deptId'), 'change', updDeptInfo);
   addEvent(document.getElementById('eeType'), 'change', updEeTypeInfo);
}

function addFuncEvents() {
   addEvent(document.getElementById('foodGrat'), 'blur', calcGrid);
   addEvent(document.getElementById('barGrat'), 'blur', calcGrid);
   addEvent(document.getElementById('defSetup'), 'blur', calcGrid);
   addEvent(document.getElementById('defClear'), 'blur', calcGrid);
   addEvent(document.getElementById('defExtra'), 'blur', calcGrid);
}

function weekFunc1(unitId, funcName) {
if (unitId=="") {
  document.getElementById("todoform").innerHTML="no unit Id";
  return;
  }
if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  } else {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function() {
  if (xmlhttp.readyState==4 && xmlhttp.status==200) {
    document.getElementById("todoform").innerHTML=xmlhttp.responseText;
    document.getElementById("todostat").innerHTML = ' ';
    f_tcalInit();
    if (funcName == 'enterFunc') {
       popright("getEes",unitId);
       addFuncEvents();
    }
  }
}
xmlhttp.open("GET",funcName+".php5?unitId="+unitId+"&eventNum=start",true);
xmlhttp.send();
}

function saveKey1(str) {
if (str=="")
  {
  document.getElementById("todoform").innerHTML="";
  return;
  }
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("todostat").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","todosave.php5?todo="+str,true);
xmlhttp.send();
}

function clearRight() {
   document.getElementById("rightcol").innerHTML="";
}

function popright(funcName, str) {
if (str=="")
  {
  document.getElementById("rightcol").innerHTML="";
  return;
  }
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("rightcol").innerHTML=xmlhttp.responseText;
    set_events2();
//    popeegrid();
    }
  }
xmlhttp.open("GET",funcName+".php5?unitId="+str,true);
xmlhttp.send();
}

function xmlhttpPost(strURL, formName) {
    var xmlHttpReq = false;
    var self = this;
    // Mozilla/Safari
    if (window.XMLHttpRequest) {
        self.xmlHttpReq = new XMLHttpRequest();
    }
    // IE
    else if (window.ActiveXObject) {
        self.xmlHttpReq = new ActiveXObject("Microsoft.XMLHTTP");
    }
    self.xmlHttpReq.open('POST', strURL, true);
    self.xmlHttpReq.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    self.xmlHttpReq.onreadystatechange = function() {
        if (self.xmlHttpReq.readyState == 4) {
            updatepage(self.xmlHttpReq.responseText);
        }
    }
    self.xmlHttpReq.send(getquerystring(formName));
}

//   The following function obtains two variables from your form (email and message)
//   and builds a string that gets sent to your PHP script.  Change this function to
//   obtain whatever fields you want from your form.

function getquerystring(formName) {

    var qstr = '';
    var elem = document.getElementById(formName).elements;
    for(var i = 0; i < elem.length; i++) {
//    	alert(elem[i].name + "=" + escape(elem[i].value));
    	if (qstr == '')
           qstr += "" + elem[i].name + "=" + escape(elem[i].value);
        else
           qstr += "&" + elem[i].name + "=" + escape(elem[i].value);
    }
    return qstr;
}

function updatepage(str){
    document.getElementById("todoform").innerHTML = str;
}

function xmlhttpPost2(strURL, qryString, resId) {
    var xmlHttpReq = false;
    var self = this;
    // Mozilla/Safari
    if (window.XMLHttpRequest) {
        self.xmlHttpReq = new XMLHttpRequest();
    }
    // IE
    else if (window.ActiveXObject) {
        self.xmlHttpReq = new ActiveXObject("Microsoft.XMLHTTP");
    }
    self.xmlHttpReq.open('POST', strURL, true);
    self.xmlHttpReq.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    self.xmlHttpReq.onreadystatechange = function() {
        if (self.xmlHttpReq.readyState == 4) {
            document.getElementById(resId).innerHTML = self.xmlHttpReq.responseText;
        }
    }
    self.xmlHttpReq.send(qryString);
}

function saveEmp() {
	var getParms = getquerystring("formEmps");
	xmlhttpPost2("saveEmps.php5", getParms, "statusRes");
}

function countType(gridRow) {
  var empCnt    = gridRow.cells[0].innerHTML;
  var gridEmpId = gridRow.cells[1].innerHTML;
  var nameType  = gridRow.cells[2].innerHTML;
  var empType = nameType.split(':');
}

function saveGrid(eType) {
   document.getElementById('statusResult').innerHTML = "";
   if (document.getElementById('funcDate').value == "")
      document.getElementById('statusResult').innerHTML = "Function Date is required before saving.";
   else
     if (document.getElementById('funcNumWk').value == "")
        document.getElementById('statusResult').innerHTML = "Function Number for the week is required before saving.";
      else
      	 if (saveFunc() == 'Saved')
            saveGrids();
         else
            document.getElementById('statusResult').innerHTML = "Error saving function.";
}

function saveFunc() {
   var qstr, unitId, eventNum;
   qstr = "funcDate=" + escape(document.getElementById('funcDate').value);
   qstr += "&wkendDate=" + escape(document.getElementById('wkendDate').innerHTML);
   qstr += "&roomNum=" + escape(document.getElementById('roomNum').value);
   qstr += "&funcType=" + escape(document.getElementById('funcType').value);
   qstr += "&funcNumWk=" + escape(document.getElementById('funcNumWk').value);
   qstr += "&foodCheck=" + escape(document.getElementById('foodCheck').value);
   qstr += "&barCheck=" + escape(document.getElementById('barCheck').value);
   qstr += "&foodBill=" + escape(document.getElementById('foodBill').value);
   qstr += "&barBill=" + escape(document.getElementById('barBill').value);
   qstr += "&foodGrat=" + escape(document.getElementById('foodGrat').value);
   qstr += "&barGrat=" + escape(document.getElementById('barGrat').value);
   qstr += "&defCovers=" + escape(document.getElementById('defCovers').value);
   qstr += "&defSetup=" + escape(document.getElementById('defSetup').value);
   qstr += "&defClear=" + escape(document.getElementById('defClear').value);
   qstr += "&defExtra=" + escape(document.getElementById('defExtra').value);

   unitId = document.getElementById('unitId').innerHTML.split(" ")[1];
   xmlhttpPost2('saveFunc.php5?unitId=' + unitId, qstr, "statusResult");
}


function saveGrids() {
   var empGrid = document.getElementById('empGrid');    //Get the table tag that holds the list of employees
   var qstr, unitId, rownum, empCnt, empType, tot, foodGrat, foodRate, foodCut, foodGrand=0, barGrat, barRate, barCut, barGrand=0, setupAmt, clearAmt, extraAmt, $getEeGroups, empCnts={};
   for (var i = 1, row; row = empGrid.rows[i]; i++) {
      qstr = "empSeq=" + escape(row.cells[0].innerHTML);
      qstr += "&emplid=" + escape(row.cells[1].innerHTML);
      qstr += "&eeType=" + escape(row.cells[4].innerHTML);
      qstr += "&foodRate=" + escape(row.cells[5].innerHTML);
      qstr += "&foodGroup=" + escape(row.cells[6].innerHTML);
      qstr += "&barRate=" + escape(row.cells[7].innerHTML);
      qstr += "&barGroup=" + escape(row.cells[8].innerHTML);
      if (row.cells[9].innerHTML == '0')
         qstr += "&baseWage=0";
      else
         qstr += "&baseWage=" + escape(row.cells[9].childNodes[0].value);
      if (row.cells[10].innerHTML == '0')
         qstr += "&hours=0";
      else
         qstr += "&hours=" + escape(row.cells[10].childNodes[0].value);
      qstr += "&setupAmt=" + escape(row.cells[11].childNodes[0].value);
      qstr += "&clearAmt=" + escape(row.cells[12].childNodes[0].value);
      qstr += "&extraAmt=" + escape(row.cells[13].childNodes[0].value);
      qstr += "&foodCut="  + escape(row.cells[14].childNodes[0].value);
      qstr += "&barCut="   + escape(row.cells[15].childNodes[0].value);
      qstr += "&totalPay=" + escape(row.cells[16].childNodes[0].value);

      unitId = document.getElementById('unitId').innerHTML.split(" ")[1];
      xmlhttpPost2('saveGrid.php5?unitId=' + unitId, qstr, "statusResult");
   }
}

function calcGrid(eType) {
   var empGrid = document.getElementById('empGrid');    //Get the table tag that holds the list of employees
   var rownum, empCnt, empType, tot, foodGrat, foodRate, foodCut, foodGrand=0, barGrat, barRate, barCut, barGrand=0, setupAmt, clearAmt, extraAmt, $getEeGroups, empCnts={};
   for (var i = 1, row; row = empGrid.rows[i]; i++) {
      rowNum   = row.cells[0].innerHTML;
      foodEmpType  = row.cells[6].innerHTML;
      barEmpType   = row.cells[8].innerHTML;
      if (foodEmpType != "")
         foodEmpCnt   = document.getElementById('empCnt' + foodEmpType).innerHTML.split(':')[1];
      else
      	 foodEmpCnt   = 0;
      if (barEmpType != "")
         barEmpCnt    = document.getElementById('empCnt' + barEmpType).innerHTML.split(':')[1];
      else
      	 barEmpCnt   = 0;
      if (row.cells[9].innerHTML == '0')
         tot = 0;
      else
         tot = 0 + parseFloat(row.cells[9].childNodes[0].value);
      foodGrat = document.getElementById('foodGrat').value;
      barGrat  = document.getElementById('barGrat').value;
      foodRate = row.cells[5].innerHTML;
      barRate  = row.cells[7].innerHTML;
      setupAmt = parseFloat(row.cells[11].childNodes[0].value);
      clearAmt = parseFloat(row.cells[12].childNodes[0].value);
      extraAmt = parseFloat(row.cells[13].childNodes[0].value);
//      setupAmt = document.getElementById('defSetup'+rowNum).value;
//      clearAmt = document.getElementById('defClear'+rowNum).value;
//      extraAmt = document.getElementById('defExtra'+rowNum).value;
      if (foodEmpCnt > 0)
          foodCut = Math.round(parseFloat(foodRate / foodEmpCnt * foodGrat)) / 100;
      else
      	  foodCut = 0;
      row.cells[14].childNodes[0].value = foodCut;
      if (barEmpCnt > 0)
          barCut = Math.round(parseFloat(barRate / barEmpCnt * barGrat)) / 100;
      else
      	  barCut = 0;
      row.cells[15].childNodes[0].value = barCut;
      tot      = Math.round((parseFloat(tot) + foodCut) * 100) / 100;
      tot      = Math.round((parseFloat(tot) + barCut) * 100) / 100;
      foodGrand = Math.round((foodGrand + foodCut) * 100) / 100;
      barGrand  = Math.round((barGrand  + barCut) * 100) / 100;
      if (setupAmt > 0)
         tot = tot + setupAmt;
      if (clearAmt > 0)
         tot = tot + clearAmt;
      if (extraAmt > 0)
         tot = tot + extraAmt;
//      alert('tot is' + tot+'  fod grat is ' + foodGrat + '  Food Rate ' + foodRate + ' EmpCnt:'+empCnt + 'Row Num: '+rowNum);
      row.cells[16].childNodes[0].value = tot;
   }
   document.getElementById('foodTotal').innerHTML = foodGrand;
   document.getElementById('barTotal').innerHTML  = barGrand;
}

function loopGrid2() {
   var empGrid = document.getElementById('empGrid');    //Get the table tag that holds the list of employees
   var nameType, empType, empTypeIdx, foodGroup, barGroup, fnd="N", empCnts={}, empCnts2={};
   for (var i = 1, row; row = empGrid.rows[i]; i++) {
      empType    = row.cells[3].innerHTML;
      empTypeIdx = row.cells[4].innerHTML;
      foodGroup  = row.cells[6].innerHTML;
      barGroup   = row.cells[8].innerHTML;
      if (empCnts.hasOwnProperty(empType)) {
         empCnts[empType] = empCnts[empType] + 1;
         }
      else {
         empCnts[empType] = 1;
      }

//      alert("Count food group: " + foodGroup + " and bar group: " + barGroup + " for emp type: " + empType);
   // {foodGroup :{Cnt: x, empType1: x1, empType2: x2, ... }}
      if (foodGroup != "") {
         if (empCnts2.hasOwnProperty(foodGroup)) {
            empCnts2[foodGroup]["Cnt"] = empCnts2[foodGroup].Cnt + 1;
            }
         else {
            empCnts2[foodGroup] = {};
            empCnts2[foodGroup].Cnt = 1;
         }
         if (empCnts2[foodGroup].hasOwnProperty(empType))
            empCnts2[foodGroup][empType] = empCnts2[foodGroup][empType] + 1;
         else
            empCnts2[foodGroup][empType] = 1;
      }
      if (barGroup != foodGroup)
         if (barGroup != "") {
            if (empCnts2.hasOwnProperty(barGroup)) {
               empCnts2[barGroup]["Cnt"] = empCnts2[barGroup].Cnt + 1;
               }
            else {
               empCnts2[barGroup] = {};
               empCnts2[barGroup].Cnt = 1;
            }
            if (empCnts2[barGroup].hasOwnProperty(empType))
               empCnts2[barGroup][empType] = empCnts2[barGroup][empType] + 1;
            else
               empCnts2[barGroup][empType] = 1;
         }

   }
   return empCnts2;
}

function removeGrid(empId) {
   var empGrid = document.getElementById('empGrid');    //Get the table tag that holds the list of employees
   var fnd="N";
   for (var i = 0, row; row = empGrid.rows[i]; i++) {
      empCnt = row.cells[0].innerHTML;
      gridEmpId = row.cells[1].innerHTML;
      if (fnd =="Y") {
         row.cells[0].innerHTML = empCnt - 1;
      } else {
       	if (empId == gridEmpId) {
       	   fnd = "Y";
       	   empGrid.deleteRow(i);
           i--;
        }
      }
   }
}

function popeedata(empRow) {
   var empId=empRow.attr('id');
   removeGrid(empId);
}

function removeEeType(empRow, eeTypeName) {
  var nameType = empRow.html().split(':');
  if (nameType[1] == " "+eeTypeName) {
     empRow.addClass('notPicked');
     empRow.removeClass('picked');
     popeedata(empRow);
  }
}

function selectEeType(empRow, eeTypeName) {
  var nameType = empRow.html().split(':');
  if (nameType[1] == " "+eeTypeName) {
     empRow.addClass('picked');
     empRow.removeClass('notPicked');
     pusheedata(empRow);
  }
}

function loopEmpList(func, parm1) {
   var empList = document.getElementById('empList');    //Get the table tag that holds the list of employees
   for (var i = 0, row; row = empList.rows[i]; i++) {
       //iterate through rows
       //rows would be accessed using the "row" variable assigned in the for loop
       for (var j = 0, col; col = row.cells[j]; j++) {
       	  doh = $("#"+col.id);
       	  func(doh, parm1);
       }
    }
}

function reset_eeTypes(eeTypeName){
   loopEmpList(removeEeType,eeTypeName);
}

function add_eeTypes(eeTypeName){
   reset_eeTypes(eeTypeName);
   loopEmpList(selectEeType,eeTypeName);
}

// Update the employee counts displayed on the screen
function updateEmpCnts() {
  var cntsTab=document.getElementById('tabEmpCnts');
  for (var i = cntsTab.rows.length - 1; i > -1; i--) {
     cntsTab.deleteRow(i);
   }

  var newInp, newrow, newcell, typeCnt=0, first, empCnts=loopGrid2();
//  for(var propt in empCnts){
//    alert('<'+propt + '>: ' + empCnts[propt]);
//     newrow=cntsTab.insertRow(typeCnt);
//     newcell=newrow.insertCell(0);
//     newcell.id="empCnt" + propt;
//     newcell.innerHTML="" + propt+': ' + empCnts[propt];

//     newcell=newrow.insertCell(1);
//     typeCnt++;
//     }
  for(var propt in empCnts){
//     alert('<'+propt + '>: ' + empCnts[propt]);
     newrow=cntsTab.insertRow(typeCnt);
     newcell=newrow.insertCell(0);
     newcell.id="empCnt" + propt;
     newcell.innerHTML="" + propt+': ' + empCnts[propt].Cnt;
     typeCnt++;

     first=0;
     for(var propt2 in empCnts[propt]){
//        alert(propt2 + " has " + empCnts[propt][propt2]);
        if (first !=0) {
           newrow=cntsTab.insertRow(typeCnt);
           newcell=newrow.insertCell(0);
           newcell.id="empType" + propt2;
           newcell.innerHTML=" -" + propt2+': ' + empCnts[propt][propt2];
           typeCnt++;
        }
        first++;
        }
     }
}

function pusheedata(empElm) {
  var emplid;
  var empGrid = document.getElementById('empGrid');    //Get the table tag that holds the list of employees
  empElm.removeClass('notPicked');
  empElm.addClass('picked');
  var defCovers = document.getElementById('defCovers').value;
  var defSetup = document.getElementById('defSetup').value;
  var defClear = document.getElementById('defClear').value;
  var defExtra = document.getElementById('defExtra').value;
  var thisRowNum, nextRow = empGrid.rows.length;
  var newrow=empGrid.insertRow(nextRow);
  var cutFlags;

  var newcell=newrow.insertCell(0);
  thisRowNum = empGrid.rows.length - 1;  //minus 1 for header
  newcell.innerHTML="" + thisRowNum;

  newcell=newrow.insertCell(1);
  emplid = empElm.attr('id');
  newcell.innerHTML=emplid;

  var nameType = empElm.html().split(':');
  newcell=newrow.insertCell(2);
  newcell.innerHTML=nameType[0];

  newcell=newrow.insertCell(3);
  newcell.innerHTML=nameType[1];

  cutFlags = empElm.attr('name').split(':');
  newcell=newrow.insertCell(4);
  newcell.innerHTML=cutFlags[10];
  newcell.setAttribute('class','hidden');

  newcell=newrow.insertCell(5);     //food rate
  newcell.innerHTML=cutFlags[0];

  newcell=newrow.insertCell(6);
  newcell.innerHTML=cutFlags[1];
  newcell.setAttribute('class','hidden');

  newcell=newrow.insertCell(7);     //bar rate
  newcell.innerHTML=cutFlags[2];

  newcell=newrow.insertCell(8);
  newcell.innerHTML=cutFlags[3];
  newcell.setAttribute('class','hidden');

  newcell=newrow.insertCell(9);     //Base Wage
  if (cutFlags[5] == "Y") {
     newcell.innerHTML='<input type="text" class="numfld" id = "bw'+ emplid + '" size="8" value="'+cutFlags[4]+'"/>';
     addEvent(document.getElementById('bw'+emplid), 'blur', calcGrid)
  } else {
     newcell.innerHTML=0;
     newcell.id="baseWage" +thisRowNum;
  }

  newcell=newrow.insertCell(10);     //Default Hours
  newcell.innerHTML='<input type="text" class="numfld" size="2" value="'+cutFlags[6] + '"/>';

  newcell=newrow.insertCell(11);     //Default Setup
  if (cutFlags[7] == "Y") {
     newcell.innerHTML='<input type="text" class="numfld" id = "ds'+ emplid + '" size="5"  value="'+defSetup + '"/>';
     addEvent(document.getElementById('ds'+emplid), 'blur', calcGrid)
  }   else
     newcell.innerHTML='<input type="text" class="numfld" size="5"  value="0"/>';

  newcell=newrow.insertCell(12);     //Default Clear
  if (cutFlags[8] == "Y") {
     newcell.innerHTML='<input type="text" class="numfld" id = "dc'+ emplid + '" size="5" value="'+defClear + '"/>';
     addEvent(document.getElementById('dc'+emplid), 'blur', calcGrid)
  }   else
     newcell.innerHTML='<input type="text" class="numfld" size="5" value="0"/>';

  newcell=newrow.insertCell(13);    //Default Extra
  if (cutFlags[9] == "Y") {
     newcell.innerHTML='<input type="text" class="numfld" id = "de' + emplid + '" size="5" value="'+defExtra + '"/>';
     addEvent(document.getElementById('de' + emplid), 'blur', calcGrid)
  }   else
     newcell.innerHTML='<input type="text" class="numfld" size="5" value="0"/>';

  newcell=newrow.insertCell(14);    //Food Cut
  newcell.innerHTML='<input type="text" class="numfld" size="8" value="0" readonly/>';

  newcell=newrow.insertCell(15);    //Bar Cut
  newcell.innerHTML='<input type="text" class="numfld" size="8" value="0" readonly/>';

  newcell=newrow.insertCell(16);    //Total Pay
  newcell.innerHTML='<input type="text" class="numfld" size="8" value="0" readonly/>';

  updateEmpCnts();
  calcGrid();
}

function popeegrid(){
   var empList = document.getElementById('empList');    //Get the table tag that holds the list of employees
   var empGrid = document.getElementById('empGrid');    //Get the table tag that holds the list of employees
   var defCovers = document.getElementById('defCovers').value;
   var emplid, empRow, newrow, newcell, doh, nameType;
   var empCnt = 0;
   for (var i = 0, row; row = empList.rows[i]; i++) {
       //iterate through rows
       //rows would be accessed using the "row" variable assigned in the for loop
       for (var j = 0, col; col = row.cells[j]; j++) {
       	  doh = $("#"+col.id);
       	  emplid = doh.attr('id');
          if (doh.hasClass('picked')) {
              pusheedata(doh);
          }
       }
    }
}

function selectee(event){
// get the form field that fired this event
  var elm = $(event.target);  // getEventSrc(event);
// This is the field that holds the base of the weblib call.  Only addition thing need is to tack on the arguement (fieldname).
   var empGrid = document.getElementById('empGrid');    //Get the table tag that holds the list of employees
  var fldName = $(".multifld.picked");
  var fldVal = event.target.id;
  var fldDescr = escape($(event.target).html());
  var cutFlags;

  var fldAct = 'select'
  if (elm.hasClass('picked')) {
  	elm.removeClass('picked');
  	elm.addClass('notPicked');
  	var fnd="N";
  	for (var i = 0, row; row = empGrid.rows[i]; i++) {
  	    empCnt = row.cells[0].innerHTML;
  	    empId = row.cells[1].innerHTML;
  	    if (fnd =="Y") {
  	    	row.cells[0].innerHTML = empCnt - 1;
         	} else {
         	if (empId == elm.attr('id')) {
         	   fnd = "Y";
         	   empGrid.deleteRow(i);
                   i--;
         	  }
	    }
        }
        updateEmpCnts();
        calcGrid();
        fldAct = 'remove'
  } else {
  	pusheedata(elm)
  }

  var unicode=event.keyCode? event.keyCode : event.charCode;

}

function set_events2(){
   $(".multiVal").click(function(event) {
            selectee(event); });
}
