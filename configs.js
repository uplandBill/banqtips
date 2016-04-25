function addEvent(obj, type, fn) {
  if (obj.addEventListener) {
      obj.addEventListener(type, fn, false);
      } else {
        obj['e' + type + fn] = fn;
        obj[type + fn] = function(){obj['e' + type + fn](window.event); }
        obj.attachEvent('on'+ type, obj[type + fn]);
      }
  }

function hasClass(ele,cls) {
  return ele.className.match(new RegExp('(\\s|^)'+cls+'(\\s|$)'));
}

function addClass(ele,cls) {
  if (!hasClass(ele,cls)) ele.className += " "+cls;
}

function removeClass(ele,cls) {
  if (hasClass(ele,cls)) {
      var reg = new RegExp('(\\s|^)'+cls+'(\\s|$)');
      ele.className=ele.className.replace(reg,' ');
  }
}

function trim1 (str) {
    return str.replace(/^\s\s*/, '').replace(/\s\s*$/, '');
}

function flipTrigger(ele) {
  if (hasClass(ele, "trigger")) {
     removeClass(ele, "trigger");
     addClass(ele, "triggers");
  } else {
     removeClass(ele, "triggers");
     addClass(ele, "trigger");
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
xmlhttp.open("GET","getConfigs.php?user="+str,true);
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
xmlhttp.open("GET",func+".php" +parms,true);
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
xmlhttp.open("GET","getEeLine.php?emplid="+emp,true);
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
    }
  }
xmlhttp.open("GET","buildEd.php?table="+tabName+"&funcName="+funcName,true);
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
    }
  }
xmlhttp.open("GET","get1.php?table="+tabName+"&where="+whereClause,true);
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
xmlhttp.open("GET",func+".php"+"?"+getParms,true);
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
   addEvent(document.getElementById('funcType'), 'blur', funcChange);
   addEvent(document.getElementById('foodGrat'), 'blur', calcGrid);
   addEvent(document.getElementById('barGrat'), 'blur', calcGrid);
   addEvent(document.getElementById('defSetup'), 'blur', calcGrid);
   addEvent(document.getElementById('defClear'), 'blur', calcGrid);
   addEvent(document.getElementById('defExtra'), 'blur', calcGrid);
}

function weekFunc1(unitId, funcName, addlParm) {
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
    f_tcalInit();
    if (funcName == 'enterFunc') {
       popright("getEes",unitId);
       addFuncEvents();
    }
  }
}
xmlhttp.open("GET",funcName+".php?unitId="+unitId+"&func=start"+addlParm,true);
xmlhttp.send();
}

function loadFunc(unitId, eventNum, addlParm) {
if (eventNum=="") {
  document.getElementById("todoform").innerHTML="no event number";
  return;
  }
if (window.XMLHttpRequest) {
  xmlhttp=new XMLHttpRequest();
  } else {
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function() {
  if (xmlhttp.readyState==4 && xmlhttp.status==200) {
    document.getElementById("todoform").innerHTML=xmlhttp.responseText;
    f_tcalInit();
    popright("getEes",unitId);
    loadEeGrid(eventNum);
    addFuncEvents();
  }
}
xmlhttp.open("GET","enterFunc.php?unitId="+unitId+"&func=start&eventNum="+eventNum,true);
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
    document.getElementById("statusResult").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","todosave.php?todo="+str,true);
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
xmlhttp.open("GET",funcName+".php?unitId="+str,true);
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

function xmlhttpPost2(strURL, qryString, resId, doFunc) {
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
        if (self.xmlHttpReq.readyState == 4 && self.xmlHttpReq.status==200) {
            var aRes = self.xmlHttpReq.responseText;
            var firstR = aRes.split(" ")[0];
            var secondR = aRes.split(" ")[1];
            if (firstR == "Saved") {
               document.getElementById(resId).innerHTML = firstR;
               if (secondR) {
                  var jObj = JSON.parse(secondR);
                  document.getElementById('eventNum').innerHTML = jObj['eventNum'];
                  if (doFunc) {
               	      doFunc();
                  }
               }
//               return firstR;   this doesn't work
            } else {
               document.getElementById(resId).innerHTML = aRes;
            }
        }
    }
    self.xmlHttpReq.send(qryString);
}

function saveEmp() {
	var getParms = getquerystring("formEmps");
	xmlhttpPost2("saveEmps.php", getParms, "statusRes");
}


// if (str=="")  {
//   document.getElementById("todoform").innerHTML="";
//   return;
//   }
// if (window.XMLHttpRequest)  {
//   xmlhttp=new XMLHttpRequest();
//   } else {
//      xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
//   }
// xmlhttp.onreadystatechange=function()  {
//   if (xmlhttp.readyState==4 && xmlhttp.status==200) {
//     document.getElementById("statusResult").innerHTML=xmlhttp.responseText;
//     }
//   }
// xmlhttp.open("GET","todosave.php?todo="+str,true);
// xmlhttp.send();

function jsonAjax(servFunc, jsonFunc, unitId, parm1) {
    var xmlHttpReq = false;
    var self = this;
    if (window.XMLHttpRequest) {
        self.xmlHttpReq = new XMLHttpRequest();
    } else {
       if (window.ActiveXObject) {
          self.xmlHttpReq = new ActiveXObject("Microsoft.XMLHTTP");
       }
    }
    self.xmlHttpReq.open('GET', ""+servFunc+".php?unitId=" + unitId + "&parm1=" + parm1, true);
    self.xmlHttpReq.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    self.xmlHttpReq.onreadystatechange = function() {
        if (self.xmlHttpReq.readyState == 4 && self.xmlHttpReq.status==200) {
            var json = self.xmlHttpReq.responseText;
            jsonFunc(json);
        }
    }
    self.xmlHttpReq.send();
}

function hideBW(jsonStr) {
  var bwList = eval('(' +jsonStr+ ')'), newDiv;
  var hideArea = document.getElementById("hiddenData");
  for (var objNum in bwList) {
     json = bwList[objNum];
     newDiv = document.createElement('div');
     newDiv.setAttribute("id","empClass"+json["emplClass"]);
     newDiv.innerHTML = json["baseWage"];
     hideArea.appendChild(newDiv);
     }
  newDiv = document.createElement('div');
  newDiv.setAttribute("id","empClass");
  newDiv.innerHTML = "0";
  hideArea.appendChild(newDiv);
  loopGrid(setBaseWage)
}

function setBaseWage(empRow) {
   var cutFlags = empRow.cells[1].getAttribute("name").split(":");
   var bw = document.getElementById("empClass"+cutFlags[1]).innerHTML;
   var bwCell = empRow.cells[7];
   removeKids(bwCell);
   if (empObj["eeBaseWage"] == "Y") {
      bwCell.innerHTML='<input type="text" class="numfld" id = "bw'+ empRow.cells[1].innerHTML + '" size="8" value="'+bw+'"/>';
      addEvent(document.getElementById('bw'+empRow.cells[1].innerHTML), 'blur', calcGrid)
   } else {
      bwCell.innerHTML=0;
      bwCell.id="baseWage" + empRow[0].innerHTML;
   }
}

function funcChange() {
   removeKids(document.getElementById('hiddenData'));
   var unitId = trim1(document.getElementById("unitId").innerHTML.split(":")[1]);
   jsonAjax("jsonGetFuncCons", hideBW, unitId, document.getElementById("funcType").value);
   calcGrid();
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
   xmlhttpPost2('saveFunc.php?unitId=' + unitId, qstr, "statusResult", saveGrids);
}


function saveGrids() {
   var empGrid = document.getElementById('empGrid');    //Get the table tag that holds the list of employees
   var eventNum = document.getElementById('eventNum').innerHTML;    //Get the table tag that holds the list of employees
   var qstr, unitId, cutFlags, rownum, empCnt, empType, tot, foodGrat, foodRate, foodCut, foodGrand=0, barGrat, barRate, barCut, barGrand=0, setupAmt, clearAmt, extraAmt, $getEeGroups, empCnts={};
   for (var i = 1, row; row = empGrid.rows[i]; i++) {
      qstr = "eventNum=" + escape(eventNum);
      qstr += "&empSeq=" + escape(row.cells[0].innerHTML);
      qstr += "&emplid=" + escape(row.cells[1].innerHTML);
      cutFlags = row.cells[1].getAttribute("name").split(":");
      qstr += "&eeType=" + escape(cutFlags[0]);
      qstr += "&getSetup=" + escape(cutFlags[1]);
      qstr += "&getClear=" + escape(cutFlags[2]);
      qstr += "&getExtra=" + escape(cutFlags[3]);
      qstr += "&eeBaseWage=" + escape(cutFlags[4]);
      
      qstr += "&foodRate=" + escape(row.cells[5].innerHTML);
      qstr += "&foodGroup=" + escape(row.cells[5].getAttribute("group"));
      qstr += "&barRate=" + escape(row.cells[6].innerHTML);
      qstr += "&barGroup=" + escape(row.cells[6].getAttribute("group"));
      if (row.cells[7].innerHTML == '0')
         qstr += "&baseWage=0";
      else
         qstr += "&baseWage=" + escape(row.cells[7].childNodes[0].value);
      if (row.cells[8].innerHTML == '0')
         qstr += "&hours=0";
      else
         qstr += "&hours=" + escape(row.cells[8].childNodes[0].value);
      qstr += "&setupAmt=" + escape(row.cells[9].childNodes[0].value);
      qstr += "&clearAmt=" + escape(row.cells[10].childNodes[0].value);
      qstr += "&extraAmt=" + escape(row.cells[11].childNodes[0].value);
      qstr += "&foodCut="  + escape(row.cells[12].childNodes[0].value);
      qstr += "&barCut="   + escape(row.cells[13].childNodes[0].value);
      qstr += "&totalPay=" + escape(row.cells[14].childNodes[0].value);

      unitId = document.getElementById('unitId').innerHTML.split(" ")[1];
      xmlhttpPost2('saveGrid.php?unitId=' + unitId, qstr, "statusResult");
   }
}

function calcGrid(eType) {
   var empGrid = document.getElementById('empGrid');    //Get the table tag that holds the list of employees
   var rownum, empCnt, cutFlags, empType, tot, foodGrat, foodRate, foodCut, foodGrand=0, barGrat, barRate, barCut, barGrand=0, setupAmt, clearAmt, extraAmt, $getEeGroups, empCnts={};
   for (var i = 1, row; row = empGrid.rows[i]; i++) {
      rowNum   = row.cells[0].innerHTML;
//      cutFlags = row.cells[1].getAttribute("name").split(":");
      foodEmpType  = row.cells[5].getAttribute("group");
      barEmpType   = row.cells[6].getAttribute("group");
      if (foodEmpType != "")
         foodEmpCnt   = document.getElementById('empCnt' + foodEmpType).innerHTML.split(':')[1];
      else
      	 foodEmpCnt   = 0;
      if (barEmpType != "")
         barEmpCnt    = document.getElementById('empCnt' + barEmpType).innerHTML.split(':')[1];
      else
      	 barEmpCnt   = 0;
      if (row.cells[7].innerHTML == '0')
         tot = 0;
      else
         tot = 0 + parseFloat(row.cells[7].childNodes[0].value);
      foodGrat = document.getElementById('foodGrat').value;
      barGrat  = document.getElementById('barGrat').value;
      foodRate = row.cells[5].innerHTML;
      barRate  = row.cells[6].innerHTML;
      setupAmt = parseFloat(row.cells[9].childNodes[0].value);
      clearAmt = parseFloat(row.cells[10].childNodes[0].value);
      extraAmt = parseFloat(row.cells[11].childNodes[0].value);
//      setupAmt = document.getElementById('defSetup'+rowNum).value;
//      clearAmt = document.getElementById('defClear'+rowNum).value;
//      extraAmt = document.getElementById('defExtra'+rowNum).value;
      if (foodEmpCnt > 0)
          foodCut = Math.round(parseFloat(foodRate / foodEmpCnt * foodGrat)) / 100;
      else
      	  foodCut = 0;
      row.cells[12].childNodes[0].value = foodCut;
      if (barEmpCnt > 0)
          barCut = Math.round(parseFloat(barRate / barEmpCnt * barGrat)) / 100;
      else
      	  barCut = 0;
      row.cells[13].childNodes[0].value = barCut;
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
      row.cells[14].childNodes[0].value = tot;
   }
   document.getElementById('foodTotal').innerHTML = foodGrand;
   document.getElementById('barTotal').innerHTML  = barGrand;
}

function loopGrid2() {
   var empGrid = document.getElementById('empGrid');    //Get the table tag that holds the list of employees
   var nameType, eeTypeDescr, foodGroup, barGroup, fnd="N", empCnts={}, empCnts2={};
   for (var i = 1, row; row = empGrid.rows[i]; i++) {
      eeTypeDescr = row.cells[3].innerHTML;
      foodGroup   = row.cells[5].getAttribute("group");
      barGroup    = row.cells[6].getAttribute("group");
      if (empCnts.hasOwnProperty(eeTypeDescr)) {
         empCnts[eeTypeDescr] = empCnts[eeTypeDescr] + 1;
         }
      else {
         empCnts[eeTypeDescr] = 1;
      }

//      alert("Count food group: " + foodGroup + " and bar group: " + barGroup + " for emp type: " + eeTypeDescr);
   // {foodGroup :{Cnt: x, eeTypeDescr1: x1, eeTypeDescr2: x2, ... }}
      if (foodGroup != "") {
         if (empCnts2.hasOwnProperty(foodGroup)) {
            empCnts2[foodGroup]["Cnt"] = empCnts2[foodGroup].Cnt + 1;
            }
         else {
            empCnts2[foodGroup] = {};
            empCnts2[foodGroup].Cnt = 1;
         }
         if (empCnts2[foodGroup].hasOwnProperty(eeTypeDescr))
            empCnts2[foodGroup][eeTypeDescr] = empCnts2[foodGroup][eeTypeDescr] + 1;
         else
            empCnts2[foodGroup][eeTypeDescr] = 1;
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
            if (empCnts2[barGroup].hasOwnProperty(eeTypeDescr))
               empCnts2[barGroup][eeTypeDescr] = empCnts2[barGroup][eeTypeDescr] + 1;
            else
               empCnts2[barGroup][eeTypeDescr] = 1;
         }
   }
   return empCnts2;
}

function eeGridSel(empRow) {
   var emplid = empRow.cells[1].innerHTML;
   chooseEe(document.getElementById(emplid));
}


function loopGrid(func) {
   var empGrid = document.getElementById('empGrid');    //Get the table tag that holds the list of employees
   var emplid;
   for (var i = 1, row; row = empGrid.rows[i]; i++) {
      func(row);
      }
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

function chooseEe(empElm) {
  removeClass(empElm, 'notPicked');
  addClass(empElm, 'picked');
}

function unChooseEe(empElm) {
  removeClass(empElm, 'picked');
  addClass(empElm, 'notPicked');
}

function popeedata(empRow) {
   var empId=empRow.getAttribute('id');
   removeGrid(empId);
}

function removeEeType(empRow, eeTypeName) {
//  var nameType = empRow.html().split(':');
  var nameType = empRow.innerHTML.split(':');
  if (nameType[1] == " "+eeTypeName) {
//     empRow.addClass('notPicked');
//     empRow.removeClass('picked');
     popeedata(empRow);
     addClass(empRow, 'notPicked');
     removeClass(empRow, 'picked');
  }
}

function selectEeType(empRow, eeTypeName) {
//  var nameType = empRow.html().split(':');
  var nameType = empRow.innerHTML.split(':');
  if (nameType[1] == " "+eeTypeName) {
//     empRow.addClass('picked');
//     empRow.removeClass('notPicked');
//     pusheedata(empRow);
     addClass(empRow, 'picked');
     removeClass(empRow, 'notPicked');
     var eeObj=buildEeObj(empRow);
     setGridRow(eeObj);
  }
}

function loopEmpList(func, parm1) {
   var empList = document.getElementById('empList');    //Get the table tag that holds the list of employees
   for (var i = 0, row; row = empList.rows[i]; i++) {
       //iterate through rows
       //rows would be accessed using the "row" variable assigned in the for loop
       for (var j = 0, col; col = row.cells[j]; j++) {
//       	  doh = $("#"+col.id);
          doh = document.getElementById(col.id);
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

function setGridRow(empObj) {
  var emplid, baseWage;
  var empGrid = document.getElementById('empGrid');    //Get the table tag that holds the list of employees

  var thisRowNum, nextRow = empGrid.rows.length;
  var newrow=empGrid.insertRow(nextRow);

  var cutFlags;

  var newcell=newrow.insertCell(0);
  thisRowNum = empGrid.rows.length - 1;  //minus 1 for header
  newcell.innerHTML="" + thisRowNum;

  newcell=newrow.insertCell(1);
  newcell.innerHTML=empObj["emplid"];
  newcell.setAttribute("id", "grid"+empObj["emplid"]);
  newcell.setAttribute("name",""+empObj["eeType"] + ":" + empObj["emplClass"] + ":" + empObj["getSetup"] + ":" + empObj["getClear"] + ":" + empObj["getExtra"] + ":" + empObj["eeBaseWage"]);

//  var nameType = empElm.html().split(':');

  newcell=newrow.insertCell(2);
  newcell.innerHTML=empObj["name"];

  newcell=newrow.insertCell(3);
  newcell.innerHTML=empObj["eeTypeDescr"];

//  cutFlags = empElm.attr('name').split(':');
  newcell=newrow.insertCell(4);
  newcell.innerHTML=".";
//  newcell.innerHTML=empObj["eeType"] + ":" + empObj["emplClass"] + ":" + empObj["getSetup"] + ":" + empObj["getClear"] + ":" + empObj["getExtra"] + ":" + empObj["eeBaseWage"];
  newcell.setAttribute('class','hidden');

  newcell=newrow.insertCell(5);     //food rate
  newcell.innerHTML=empObj["foodRate"];
  newcell.setAttribute("group",empObj["foodGroup"]);

//  newcell=newrow.insertCell(6);
//  newcell.innerHTML=empObj["foodGroup"];
//  newcell.setAttribute('class','hidden');

  newcell=newrow.insertCell(6);     //bar rate
  newcell.innerHTML=empObj["barRate"];
  newcell.setAttribute("group",empObj["barGroup"]);

//  newcell=newrow.insertCell(8);
//  newcell.innerHTML=empObj["barGroup"];
//  newcell.setAttribute('class','hidden');

  newcell=newrow.insertCell(7);     //Base Wage
  if (empObj["eeBaseWage"] == "Y") {
     baseWage = document.getElementById("empClass"+empObj["emplClass"]).innerHTML;
     newcell.innerHTML='<input type="text" class="numfld" id = "bw'+ empObj["emplid"] + '" size="8" value="'+baseWage+'"/>';
     addEvent(document.getElementById('bw'+empObj["emplid"]), 'blur', calcGrid)
  } else {
     newcell.innerHTML=0;
     newcell.id="baseWage" +thisRowNum;
  }

  newcell=newrow.insertCell(8);     //Default Hours
  newcell.innerHTML='<input type="text" class="numfld" size="2" value="'+empObj["hours"] + '"/>';

  newcell=newrow.insertCell(9);     //Default Setup
  if (empObj["getSetup"] == "Y") {
     newcell.innerHTML='<input type="text" class="numfld" id = "ds'+ empObj["emplid"] + '" size="5"  value="'+empObj["setupAmt"] + '"/>';
     addEvent(document.getElementById('ds'+empObj["emplid"]), 'blur', calcGrid)
  }   else
     newcell.innerHTML='<input type="text" class="numfld" size="5"  value="0"/>';

  newcell=newrow.insertCell(10);     //Default Clear
  if (empObj["getClear"] == "Y") {
     newcell.innerHTML='<input type="text" class="numfld" id = "dc'+ empObj["emplid"] + '" size="5" value="'+empObj["clearAmt"] + '"/>';
     addEvent(document.getElementById('dc'+empObj["emplid"]), 'blur', calcGrid)
  }   else
     newcell.innerHTML='<input type="text" class="numfld" size="5" value="0"/>';

  newcell=newrow.insertCell(11);    //Default Extra
  if (empObj["getExtra"] == "Y") {
     newcell.innerHTML='<input type="text" class="numfld" id = "de' + empObj["emplid"] + '" size="5" value="'+empObj["extraAmt"] + '"/>';
     addEvent(document.getElementById('de' + empObj["emplid"]), 'blur', calcGrid)
  }   else
     newcell.innerHTML='<input type="text" class="numfld" size="5" value="0"/>';

  newcell=newrow.insertCell(12);    //Food Cut
  newcell.innerHTML='<input type="text" class="numfld" size="8" value=' +empObj["foodCut"] +' readonly/>';

  newcell=newrow.insertCell(13);    //Bar Cut
  newcell.innerHTML='<input type="text" class="numfld" size="8" value=' +empObj["barCut"] +' readonly/>';

  newcell=newrow.insertCell(14);    //Total Pay
  newcell.innerHTML='<input type="text" class="numfld" size="8" value=' +empObj["totalPay"] +' readonly/>';

  updateEmpCnts();  ///???
  calcGrid();
}

// Build a JSON object for the employee grid for the employee from the employee list as passed in the the id reference.
function buildEeObj(idEmplid) {
   var eeObj = {}, cutFlags;
   var defSetup = document.getElementById('defSetup').value;
   var defClear = document.getElementById('defClear').value;
   var defExtra = document.getElementById('defExtra').value;

   eeObj["unitId"]=document.getElementById("unitId").innerHTML.split(":")[1];
   eeObj["eventNum"]=document.getElementById("eventNum").innerHTML;
   eeObj["empSeq"]=0;
   eeObj["emplid"]=idEmplid.getAttribute("id");
   eeObj["name"]=idEmplid.innerHTML.split(":")[0];
   cutFlags=idEmplid.getAttribute("name").split(":");
   eeObj["eeType"]=cutFlags[0];
   eeObj["eeTypeDescr"]=idEmplid.innerHTML.split(":")[1];
   eeObj["emplClass"]=cutFlags[1];
   eeObj["getSetup"]=cutFlags[2];
   eeObj["getClear"]=cutFlags[3];
   eeObj["getExtra"]=cutFlags[4];
   eeObj["foodRate"]=cutFlags[6];
   eeObj["foodGroup"]=cutFlags[7];
   eeObj["barRate"]=cutFlags[8];
   eeObj["barGroup"]=cutFlags[9];
   eeObj["eeBaseWage"]=cutFlags[5];
   eeObj["baseWage"]=cutFlags[10];
   eeObj["hours"]=cutFlags[11];
   if (cutFlags[1] == "Y") {
     eeObj["setupAmt"]=defSetup;
   } else {
     eeObj["setupAmt"]=0;
   }
   if (cutFlags[2] == "Y") {
     eeObj["clearAmt"]=defClear;
   } else {
     eeObj["clearAmt"]=0;
   }
   if (cutFlags[3] == "Y") {
     eeObj["extraAmt"]=defExtra;
   } else {
     eeObj["extraAmt"]=0;
   }
   eeObj["foodCut"]=0;
   eeObj["barCut"]=0;
   eeObj["totalPay"]=0;
   return eeObj;
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

  var nameType = empElm.html().split(':');
  cutFlags = empElm.attr('name').split(':');

  newcell=newrow.insertCell(1);
  emplid = empElm.attr('id');
  newcell.innerHTML=emplid;
  newcell.setAttribute("id", "grid"+emplid);
  newcell.setAttribute("name",""+cutFlags[0] + ":" + cutFlags[1] + ":" + cutFlags[2] + ":" + cutFlags[3] + ":" + cutFlags[4]);

  newcell=newrow.insertCell(2);
  newcell.innerHTML=nameType[0];

  newcell=newrow.insertCell(3);
  newcell.innerHTML=nameType[1];

  newcell=newrow.insertCell(4);
  newcell.innerHTML=".";
//  newcell.innerHTML=cutFlags[0] + ":" + cutFlags[1] + ":" + cutFlags[2] + ":" + cutFlags[3] + ":" + cutFlags[4];
  newcell.setAttribute('class','hidden');

  newcell=newrow.insertCell(5);     //food rate
  newcell.innerHTML=cutFlags[5];

  newcell=newrow.insertCell(6);     //food group
  newcell.innerHTML=cutFlags[6];
  newcell.setAttribute('class','hidden');

  newcell=newrow.insertCell(7);     //bar rate
  newcell.innerHTML=cutFlags[7];

  newcell=newrow.insertCell(8);
  newcell.innerHTML=cutFlags[8];    //bar group
  newcell.setAttribute('class','hidden');

  newcell=newrow.insertCell(9);     //Base Wage
  if (cutFlags[1] == "Y") {
     newcell.innerHTML='<input type="text" class="numfld" id = "bw'+ emplid + '" size="8" value="'+cutFlags[9]+'"/>';
     addEvent(document.getElementById('bw'+emplid), 'blur', calcGrid)
  } else {
     newcell.innerHTML=0;
     newcell.id="baseWage" +thisRowNum;
  }

  newcell=newrow.insertCell(10);     //Default Hours
  newcell.innerHTML='<input type="text" class="numfld" size="2" value="'+cutFlags[10] + '"/>';

  newcell=newrow.insertCell(11);     //Default Setup
  if (cutFlags[2] == "Y") {
     newcell.innerHTML='<input type="text" class="numfld" id = "ds'+ emplid + '" size="5"  value="'+defSetup + '"/>';
     addEvent(document.getElementById('ds'+emplid), 'blur', calcGrid)
  }   else
     newcell.innerHTML='<input type="text" class="numfld" size="5"  value="0"/>';

  newcell=newrow.insertCell(12);     //Default Clear
  if (cutFlags[3] == "Y") {
     newcell.innerHTML='<input type="text" class="numfld" id = "dc'+ emplid + '" size="5" value="'+defClear + '"/>';
     addEvent(document.getElementById('dc'+emplid), 'blur', calcGrid)
  }   else
     newcell.innerHTML='<input type="text" class="numfld" size="5" value="0"/>';

  newcell=newrow.insertCell(13);    //Default Extra
  if (cutFlags[4] == "Y") {
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


function findEE(emplid) {
  var empList=document.getElementById('empList');
  for (var i = 0, row; row = empList.rows[i]; i++) {
     if (row.cells[0].id == emplid) {
     	alert("Found emp at " + i);
     }
  }
}

//  Populate the EE Grid from a saved function
function loadEeGrid(eventNum) {
   var xmlhttp, json, newrow, newcell, emplid, empData;
   if (window.XMLHttpRequest) {
      xmlhttp=new XMLHttpRequest();
   } else {
      xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
   }
   xmlhttp.onreadystatechange=function() {
   if (xmlhttp.readyState==4 && xmlhttp.status==200) {
      var empGrid = document.getElementById("empGrid");
      var thisRowNum, nextRow = empGrid.rows.length;
      var empList = eval('(' +xmlhttp.responseText+ ')');
      for (var empVal in empList) {
      	  json = empList[empVal];

          setGridRow(json);
          }
      loopGrid(eeGridSel);
      }
   }
   xmlhttp.open("GET","jsonFuncEmps.php?eventNum="+eventNum,true);
   xmlhttp.send();
}

// This isnt in use now
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
//              pusheedata(doh);
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
  var cutFlags, eeObj;

  var fldAct = 'select';
  if (hasClass(event.target, 'picked')) {
  	unChooseEe(event.target);
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
        fldAct = 'remove';
  } else {
  	eeObj=buildEeObj(event.target);
  	setGridRow(eeObj);
  	chooseEe(event.target);
  	for (var p in eeObj) {
//  	   alert(p + ':' + eeObj[p]);  	
  	}
//  	pusheedata(elm);
  }

  var unicode=event.keyCode? event.keyCode : event.charCode;
}

function set_events2(){
   $(".multiVal").click(function(event) {
            selectee(event); });
}

function removeKids(elm) {
  var childrenCnt = elm.childNodes.length;
  if (childrenCnt > 0) {
      while (elm.hasChildNodes()){
	 elm.removeChild(elm.firstChild);
      }
  }   
}

//  Populate the EE Grid from a saved function
function eeSummWeek(unitId) {
   var xmlhttp, json, newrow, newcell, emplid, formDiv, empData;
   formDiv=document.getElementById("todoform");
   removeKids(formDiv);
   var t = document.createElement('table');
   t.setAttribute("id", "listGrid");
   formDiv.appendChild(t);
   eeSummHead(t);
   if (window.XMLHttpRequest) {
      xmlhttp=new XMLHttpRequest();
   } else {
      xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
   }
   xmlhttp.onreadystatechange=function() {
   if (xmlhttp.readyState==4 && xmlhttp.status==200) {
//      var empGrid = document.getElementById("eeSummWeek");
//      var thisRowNum, nextRow = empGrid.rows.length;
      var empList = eval('(' +xmlhttp.responseText+ ')');
      for (var empVal in empList) {
      	  json = empList[empVal];

          setEeSumm(json);
          }
      }
   }
   xmlhttp.open("GET","jsonEmpSumm.php?unitId="+unitId,true);
   xmlhttp.send();
}

function eeSummHead(outGrid) {
  var newrow=outGrid.insertRow(0);

  var newcell=newrow.insertCell(0);
  newcell.innerHTML="Row";
  newcell.setAttribute("class", "summhead");
  var newcell=newrow.insertCell(1);
  newcell.innerHTML="Emplid";
  newcell.setAttribute("class", "summhead");
  var newcell=newrow.insertCell(2);
  newcell.innerHTML="Name";
  newcell.setAttribute("class", "summhead");
  var newcell=newrow.insertCell(3);
  newcell.innerHTML="Position";
  newcell.setAttribute("class", "summhead");
  var newcell=newrow.insertCell(4);
  newcell.innerHTML="Functions";
  newcell.setAttribute("class", "summhead");
  var newcell=newrow.insertCell(5);
  newcell.innerHTML="Base Wage";
  newcell.setAttribute("class", "summhead");
  var newcell=newrow.insertCell(6);
  newcell.innerHTML="Hours";
  newcell.setAttribute("class", "summhead");
  var newcell=newrow.insertCell(7);
  newcell.innerHTML="Setup";
  newcell.setAttribute("class", "summhead");
  var newcell=newrow.insertCell(8);
  newcell.innerHTML="Clear";
  newcell.setAttribute("class", "summhead");
  var newcell=newrow.insertCell(9);
  newcell.innerHTML="Extra";
  newcell.setAttribute("class", "summhead");
  var newcell=newrow.insertCell(10);
  newcell.innerHTML="Food";
  newcell.setAttribute("class", "summhead");
  var newcell=newrow.insertCell(11);
  newcell.innerHTML="Bar";
  newcell.setAttribute("class", "summhead");
  var newcell=newrow.insertCell(12);
  newcell.innerHTML="Total Pay";
  newcell.setAttribute("class", "summhead");
}

function setEeSumm(summObj) {
  var emplid;
  var outGrid = document.getElementById('listGrid');    //Get the table tag that holds the list of employees

  var thisRowNum, nextRow = outGrid.rows.length;
  var newrow=outGrid.insertRow(nextRow);

  var newcell=newrow.insertCell(0);
  thisRowNum = outGrid.rows.length - 1;  //minus 1 for header
  newcell.innerHTML="" + thisRowNum;

  newcell=newrow.insertCell(1);
  newcell.innerHTML=summObj["emplid"];

  newcell=newrow.insertCell(2);
  var anch = document.createElement('a');
  anch.setAttribute("href","javascript:void(0);");
  anch.setAttribute("onclick","eeDetsWeek('" +summObj["emplid"]+ "','" +summObj["unitId"]+ "');");
  anch.innerHTML=summObj["name"];
  newcell.appendChild(anch);
//  newcell.innerHTML=summObj["name"];

  newcell=newrow.insertCell(3);
  newcell.innerHTML=summObj["eeTypeDescr"];

  newcell=newrow.insertCell(4);
  newcell.innerHTML=summObj["funcTot"];

  newcell=newrow.insertCell(5);
  newcell.innerHTML=summObj["sumBaseWage"];
  newcell.setAttribute("class", "summfld");

  newcell=newrow.insertCell(6);
  newcell.innerHTML=summObj["sumHours"];
  newcell.setAttribute("class", "summfld");

  newcell=newrow.insertCell(7);
  newcell.innerHTML=summObj["sumSetup"];
  newcell.setAttribute("class", "summfld");

  newcell=newrow.insertCell(8);
  newcell.innerHTML=summObj["sumClear"];
  newcell.setAttribute("class", "summfld");

  newcell=newrow.insertCell(9);
  newcell.innerHTML=summObj["sumExtra"];
  newcell.setAttribute("class", "summfld");

  newcell=newrow.insertCell(10);
  newcell.innerHTML=summObj["sumFood"];
  newcell.setAttribute("class", "summfld");

  newcell=newrow.insertCell(11);
  newcell.innerHTML=summObj["sumBar"];
  newcell.setAttribute("class", "summfld");

  newcell=newrow.insertCell(12);
  newcell.innerHTML=summObj["sumTotal"];
  newcell.setAttribute("class", "summfld");
}

function eeDetsWeek(emplid, unitId) {
   var xmlhttp, json, newrow, newcell, emplid, formDiv, empData;
   formDiv=document.getElementById("todoform");
   var childrenCnt = formDiv.childNodes.length;
   if (childrenCnt > 0) {
       while (formDiv.hasChildNodes()){
	  formDiv.removeChild(formDiv.firstChild);
	}
    }   
   var t = document.createElement('table');
   t.setAttribute("id", "listGrid");
   formDiv.appendChild(t);
   eeDetsHead(t);
   if (window.XMLHttpRequest) {
      xmlhttp=new XMLHttpRequest();
   } else {
      xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
   }
   xmlhttp.onreadystatechange=function() {
   if (xmlhttp.readyState==4 && xmlhttp.status==200) {
      var empList = eval('(' +xmlhttp.responseText+ ')');
      for (var empVal in empList) {
      	  json = empList[empVal];

          setEeDets(json);
          }
      var retButt=document.createElement("img");
      retButt.setAttribute("src","./images/returnButton.gif");
      retButt.setAttribute("onclick","eeSummWeek('" +unitId+ "')");
      formDiv.appendChild(retButt);
      }
   }
   xmlhttp.open("GET","jsonEmpDetsWk.php?unitId="+unitId+"&emplid="+emplid,true);
   xmlhttp.send();
}

function eeDetsHead(outGrid) {
  var newrow=outGrid.insertRow(0);

  var newcell=newrow.insertCell(0);
  newcell.innerHTML="Row";
  newcell.setAttribute("class", "summhead");
  var newcell=newrow.insertCell(1);
  newcell.innerHTML="Emplid";
  newcell.setAttribute("class", "summhead");
  var newcell=newrow.insertCell(2);
  newcell.innerHTML="Name";
  newcell.setAttribute("class", "summhead");
  var newcell=newrow.insertCell(3);
  newcell.innerHTML="Position";
  newcell.setAttribute("class", "summhead");
  var newcell=newrow.insertCell(4);
  newcell.innerHTML="Func date";
  newcell.setAttribute("class", "summhead");
  var newcell=newrow.insertCell(5);
  newcell.innerHTML="Base Wage";
  newcell.setAttribute("class", "summhead");
  var newcell=newrow.insertCell(6);
  newcell.innerHTML="Hours";
  newcell.setAttribute("class", "summhead");
  var newcell=newrow.insertCell(7);
  newcell.innerHTML="Setup";
  newcell.setAttribute("class", "summhead");
  var newcell=newrow.insertCell(8);
  newcell.innerHTML="Clear";
  newcell.setAttribute("class", "summhead");
  var newcell=newrow.insertCell(9);
  newcell.innerHTML="Extra";
  newcell.setAttribute("class", "summhead");
  var newcell=newrow.insertCell(10);
  newcell.innerHTML="Food";
  newcell.setAttribute("class", "summhead");
  var newcell=newrow.insertCell(11);
  newcell.innerHTML="Bar";
  newcell.setAttribute("class", "summhead");
  var newcell=newrow.insertCell(12);
  newcell.innerHTML="Total Pay";
  newcell.setAttribute("class", "summhead");
}

function setEeDets(summObj) {
  var emplid;
  var outGrid = document.getElementById('listGrid');    //Get the table tag that holds the list of employees

  var thisRowNum, nextRow = outGrid.rows.length;
  var newrow=outGrid.insertRow(nextRow);

  var newcell=newrow.insertCell(0);
  thisRowNum = outGrid.rows.length - 1;  //minus 1 for header
  newcell.innerHTML="" + thisRowNum;

  newcell=newrow.insertCell(1);
  newcell.innerHTML=summObj["emplid"];

  newcell=newrow.insertCell(2);
  newcell.innerHTML=summObj["name"];

  newcell=newrow.insertCell(3);
  newcell.innerHTML=summObj["eeTypeDescr"];

  newcell=newrow.insertCell(4);
  newcell.innerHTML=summObj["funcDate"];
//  newcell.setAttribute("class", "summfld");

  newcell=newrow.insertCell(5);
  newcell.innerHTML=summObj["sumBaseWage"];
  newcell.setAttribute("class", "summfld");

  newcell=newrow.insertCell(6);
  newcell.innerHTML=summObj["sumHours"];
  newcell.setAttribute("class", "summfld");

  newcell=newrow.insertCell(7);
  newcell.innerHTML=summObj["sumSetup"];
  newcell.setAttribute("class", "summfld");

  newcell=newrow.insertCell(8);
  newcell.innerHTML=summObj["sumClear"];
  newcell.setAttribute("class", "summfld");

  newcell=newrow.insertCell(9);
  newcell.innerHTML=summObj["sumExtra"];
  newcell.setAttribute("class", "summfld");

  newcell=newrow.insertCell(10);
  newcell.innerHTML=summObj["sumFood"];
  newcell.setAttribute("class", "summfld");

  newcell=newrow.insertCell(11);
  newcell.innerHTML=summObj["sumBar"];
  newcell.setAttribute("class", "summfld");

  newcell=newrow.insertCell(12);
  newcell.innerHTML=summObj["sumTotal"];
  newcell.setAttribute("class", "summfld");
}

function funcsWeek(unitId) {
   var xmlhttp, json, newrow, newcell, emplid, formDiv, empData;
   formDiv=document.getElementById("todoform");
   var childrenCnt = formDiv.childNodes.length;
   if (childrenCnt > 0) {
       while (formDiv.hasChildNodes()){
	  formDiv.removeChild(formDiv.firstChild);
	}
    }   
   var t = document.createElement('table');
   t.setAttribute("id", "listGrid");
   formDiv.appendChild(t);
   funcsHead(t);
   if (window.XMLHttpRequest) {
      xmlhttp=new XMLHttpRequest();
   } else {
      xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
   }
   xmlhttp.onreadystatechange=function() {
   if (xmlhttp.readyState==4 && xmlhttp.status==200) {
      var empList = eval('(' +xmlhttp.responseText+ ')');
      for (var empVal in empList) {
      	  json = empList[empVal];

          setFuncs(json);
          }
      var retButt=document.createElement("img");
      retButt.setAttribute("src","./images/returnButton.gif");
      retButt.setAttribute("onclick","funcsWeek('" +unitId+ "')");
      formDiv.appendChild(retButt);
      }
   }
   xmlhttp.open("GET","jsonGetFuncsWk.php?unitId="+unitId,true);
   xmlhttp.send();
}

function funcsHead(outGrid) {
  var newrow=outGrid.insertRow(0);

  var newcell=newrow.insertCell(0);
  newcell.innerHTML="Row";
  newcell.setAttribute("class", "summhead");
  var newcell=newrow.insertCell(1);
  newcell.innerHTML="FuncNum";
  newcell.setAttribute("class", "summhead");
  var newcell=newrow.insertCell(2);
  newcell.innerHTML="Func Date";
  newcell.setAttribute("class", "summhead");
  var newcell=newrow.insertCell(3);
  newcell.innerHTML="Room Name";
  newcell.setAttribute("class", "summhead");
  var newcell=newrow.insertCell(4);
  newcell.innerHTML="Func Type";
  newcell.setAttribute("class", "summhead");
  var newcell=newrow.insertCell(5);
  newcell.innerHTML="Food Grat";
  newcell.setAttribute("class", "summhead");
  var newcell=newrow.insertCell(6);
  newcell.innerHTML="Bar Grat";
  newcell.setAttribute("class", "summhead");
}

function setFuncs(summObj) {
  var emplid;
  var outGrid = document.getElementById('listGrid');    //Get the table tag that holds the list of employees

  var thisRowNum, nextRow = outGrid.rows.length;
  var newrow=outGrid.insertRow(nextRow);

  var newcell=newrow.insertCell(0);
  thisRowNum = outGrid.rows.length - 1;  //minus 1 for header
  newcell.innerHTML="" + thisRowNum;

  newcell=newrow.insertCell(1);
  newcell.innerHTML=summObj["funcNumWk"];

  newcell=newrow.insertCell(2);
  var anch = document.createElement('a');
  anch.setAttribute("href","javascript:void(0);");
  anch.setAttribute("onclick","loadFunc('" +summObj["unitId"]+ "','" +summObj["eventNum"]+ "');");
  anch.innerHTML=summObj["funcDate"];
  newcell.appendChild(anch);
//  newcell.innerHTML=summObj["funcDate"];

  newcell=newrow.insertCell(3);
  newcell.innerHTML=summObj["roomDescr"];

  newcell=newrow.insertCell(4);
  newcell.innerHTML=summObj["funcDescr"];
//  newcell.setAttribute("class", "summfld");

  newcell=newrow.insertCell(5);
  newcell.innerHTML=summObj["foodGrat"];
  newcell.setAttribute("class", "summfld");

  newcell=newrow.insertCell(6);
  newcell.innerHTML=summObj["barGrat"];
  newcell.setAttribute("class", "summfld");

}