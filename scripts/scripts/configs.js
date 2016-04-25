function reduce(combFunc, base, listArr) {
   forEach(listArr, function (listItem) {
   	base = combFunc(base, listItem);
   });
   return base;
}

function add(a, b) {
   return a + b;
}

function sum(numbArr) {
   return reduce(add, 0, numbArr);
}

function getText(node) {

    if (node.nodeType === 3) {
        return node.data;
    }

    var txt = '';

    if (node = node.firstChild) do {
        txt += getText(node);
    } while (node = node.nextSibling);

    return txt;

}

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
  if (ele)
  return ele.className.match(new RegExp('(\\s|^)'+cls+'(\\s|$)'));
  else
  	return false;
}

function addClass(ele,cls) {
  if (ele && !hasClass(ele,cls)) ele.className += " "+cls;
}

function removeClass(ele,cls) {
  if (ele && hasClass(ele,cls)) {
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
   e = e || window.event;
   var deptId = document.getElementById('deptId').value;
   var unitId = document.getElementById('unitId').value;
   get2("getDeptInfo","unitId="+unitId+"&deptId="+deptId,"deptInfo");
}

function updEeTypeInfo(e) {
   e = e || window.event;
   var eeType = document.getElementById('eeType').value;
   var unitId = document.getElementById('unitId').value;
   get2("getEeTypeInfo","unitId="+unitId+"&eeType="+eeType,"eeTypeInfo");
}

function addEeEvents() {
   addEvent(document.getElementById('deptId'), 'change', updDeptInfo);
   addEvent(document.getElementById('eeType'), 'change', updEeTypeInfo);
}

function addFuncEvents() {
//   addEvent(document.getElementById('funcType'), 'blur', funcChange);
   addEvent(document.getElementById('funcType'), 'change', funcChange);
   addEvent(document.getElementById('totCovers'), 'blur', calcGrid);
   addEvent(document.getElementById('foodGrat'), 'blur', calcGrid);
   addEvent(document.getElementById('barGrat'), 'blur', calcGrid);
   addEvent(document.getElementById('defSetup'), 'blur', calcGrid);
   addEvent(document.getElementById('defClear'), 'blur', calcGrid);
   addEvent(document.getElementById('defExtra'), 'blur', calcGrid);
   addEvent(document.getElementById('funcNumWk'), 'change', funcNumChange);
}

function weekFunc1(unitId, funcName, addlParm, addclass) {
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
    removeClass(document.getElementById("todoform"),"listarea");
    removeClass(document.getElementById("todoform"),"formarea");
    addClass(document.getElementById("todoform"),addclass);
    document.getElementById("todoform").innerHTML=xmlhttp.responseText;
    f_tcalInit();
    if (funcName == 'enterFunc') {
       popright("getEes",unitId);
       addFuncEvents();
    } else {
       var t = new SortableTable(document.getElementById('empsList'), 100);
    }
  }
}
xmlhttp.open("GET",funcName+".php5?unitId="+unitId+"&func=start"+addlParm,true);
xmlhttp.send();
}

function loadFunc(e) {
   e = e || window.event;
   if (e.target) var targ = e.target;
   else if (e.srcElement) var targ = e.srcElement;
   var unitId = targ.getAttribute("unitid");
   var eventNum = targ.getAttribute("eventnum");
//   alert("Go get " + unitId + " eve " + eventNum); 
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
//    popright("getEes",unitId);    //wmr
    loadEeGrid(eventNum, unitId);
    addFuncEvents();
  }
}
xmlhttp.open("GET","enterFunc.php5?unitId="+unitId+"&func=start&eventNum="+eventNum,true);
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
xmlhttp.open("GET","todosave.php5?todo="+str,true);
xmlhttp.send();
}

function clearRight() {
   document.getElementById("rightcol").innerHTML="";
}

function popright(funcName, str) {
if (str=="")  {
  document.getElementById("rightcol").innerHTML="";
  return;
  }
if (window.XMLHttpRequest)  {// code for IE7+, Firefox, Chrome, Opera, Safari
  var xmlhttp=new XMLHttpRequest();
  } else  {// code for IE6, IE5
  var xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)    {
    document.getElementById("rightcol").innerHTML=xmlhttp.responseText;
    set_events2();
    loopGrid(eeGridSel);
    }
  }
xmlhttp.open("GET",funcName+".php5?unitId="+str,true);
xmlhttp.send();
}

//who cares about shit they don't have the balls to say to your face

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
                  }
               }
//               return firstR;   this doesn't work
            if (doFunc) {
        	      doFunc();
            } else {
               document.getElementById(resId).innerHTML = aRes;
            }
        }
        else
           document.getElementById(resId).innerHTML = "What the ??";
    }
    self.xmlHttpReq.send(qryString);
}

function xmlhttpPost2a(strURL, qryString, resId, doFunc) {
    var xmlHttpReq = false;
    // Mozilla/Safari
    if (window.XMLHttpRequest) {
        xmlHttpReq = new XMLHttpRequest();
    }
    // IE
    else if (window.ActiveXObject) {
        xmlHttpReq = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlHttpReq.open('POST', strURL, true);
    xmlHttpReq.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xmlHttpReq.onreadystatechange = function() {
        if (xmlHttpReq.readyState == 4 && self.xmlHttpReq.status==200) {
            var aRes = xmlHttpReq.responseText;
            var firstR = aRes.split(" ")[0];
            var secondR = aRes.split(" ")[1];
            if (firstR == "Saved") {
               document.getElementById(resId).innerHTML = firstR;
               if (secondR) {
                  var jObj = JSON.parse(secondR);
                  document.getElementById('eventNum').innerHTML = jObj['eventNum'];
                  }
               }
//               return firstR;   this doesn't work
            if (doFunc) {
        	      doFunc();
            } else {
               document.getElementById(resId).innerHTML = aRes;
            }
        }
        else
           document.getElementById(resId).innerHTML = "What the ??";
    }
    xmlHttpReq.send(qryString);
}

function setEmplid(json) {
   var jsonObj=eval('(' +json+ ')');
   if (jsonObj["1"]) {
      var nextEmp = jsonObj["1"]["lastTempId"];
      }
   else
      var nextEmp = "error";
   document.getElementById('emplid').value=nextEmp;
}

function xmlhttpPost3(strURL, jsonString, resId, doFunc) {
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
    self.xmlHttpReq.setRequestHeader('Content-Type', 'application/json', true);
    self.xmlHttpReq.onreadystatechange = function() {
        if (self.xmlHttpReq.readyState == 4 && self.xmlHttpReq.status==200) {
            document.getElementById("hiddenData3").innerHTML = self.xmlHttpReq.responseText;
            var aRes = eval('(' +self.xmlHttpReq.responseText+ ')');
            if (aRes["result"] == "Saved")
               document.getElementById(resId).innerHTML = "Function Saved with " + aRes["rows"] + " entries."; 
            else
               document.getElementById(resId).innerHTML = "Warning: " +aRes["result"] + " " + aRes["rows"] + " saved."; 
            document.getElementById('eventNum').innerHTML = aRes["eventNum"];
            if (doFunc) {
               doFunc();
            } 
        }
        else
           document.getElementById(resId).innerHTML = "Waiting ....";
    }
    self.xmlHttpReq.send(JSON.stringify(jsonString));
}

function getTempId(unitId) {
   jsonAjax("jsonGetNextTemp", setEmplid, unitId, '');
}

function saveEmp() {
	var getParms = getquerystring("formEmps");
	xmlhttpPost2("saveEmps.php5", getParms, "statusRes");
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
// xmlhttp.open("GET","todosave.php5?todo="+str,true);
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
    self.xmlHttpReq.open('GET', ""+servFunc+".php5?unitId=" + unitId + "&parm1=" + parm1, true);
    self.xmlHttpReq.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    self.xmlHttpReq.onreadystatechange = function() {
        if (self.xmlHttpReq.readyState == 4 && self.xmlHttpReq.status==200) {
            var json = self.xmlHttpReq.responseText;
            jsonFunc(json);
        }
    }
    self.xmlHttpReq.send();
}

function get_emp_type_info(eeType) {
    var json =  eval('(' +document.getElementById("empTypeOpts").innerHTML+ ')');
    var eeTypeObj = json[eeType];
    return eeTypeObj;
}


// Using the calculation info stored in the hidden2 area, determine the compuration method for the given function, emp type, and gratity type
function get_calc_method(funcType, eeType, grat) {
  var jsonCalcComp = eval('(' +document.getElementById("calcComp").innerHTML+ ')');
//  alert("Get for " +funcType+ " and " + eeType+ " for " +grat);
  if (jsonCalcComp[funcType])
     if (jsonCalcComp[funcType][eeType])
        if (grat == "food")
           return jsonCalcComp[funcType][eeType]["foodMeth"];
        else
           return jsonCalcComp[funcType][eeType]["barMeth"];
     else
        return "#";
  else
     return "#";
}

function get_unit_data(unitId) {
  var jsonUnit = eval('(' +document.getElementById("unitData").innerHTML+ ')');
//  alert("Get for " +funcType+ " and " + eeType+ " for " +grat);
  if (jsonUnit[unitId])
     return jsonUnit[unitId];
  else
     return {};
}

function get_payGrp_data() {
  var jsonPG = eval('(' +document.getElementById("payGrps").innerHTML+ ')');
//  alert("Get for " +funcType+ " and " + eeType+ " for " +grat);
  if (jsonPG)
     return jsonPG;
  else
     return {};
}

function get_ecMeth() {
   var unitId=document.getElementById('unitId').innerHTML.split(" ")[1];
   var unitData = get_unit_data(unitId);
   var ecMeth = unitData["ecMeth"];
   return ecMeth;
}

function get_payGrp_emplClass(payGrp) {
   var payGrpData = get_payGrp_data();
   var emplClass = payGrpData[payGrp]["emplClass"];
   return emplClass;
}

// When the function type changes, the hidden data for base wages (by empl class) must be updated.
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

function get_baseWage(emplClass, payGrp) {
   var ecMeth = get_ecMeth();
//   alert("Get bw for " + emplClass + " / " + payGrp);
   if (ecMeth == "2")
      emplClass=get_payGrp_emplClass(payGrp);
   if (document.getElementById("empClass"+emplClass)) 
      return document.getElementById("empClass"+emplClass).innerHTML;
   else
      return 0;
}

function setBaseWage(empRow) {
//   var eeType = empRow.cells[3].childNodes[0].value;
//   var emplClass="";
   var typeDetails = {};
   typeDetails["eeType"] = empRow.cells[3].childNodes[0].value;
   getEeTypeDets(typeDetails);
//   if (ecMeth == "1")
//      emplClass=typeDetails["emplClass"];
//   else
//      emplClass=get_payGrp_emplClass(empRow.cells[1].getAttribute("name").split(":")[2]);
//   
//   if (document.getElementById("empClass"+emplClass)) {
//      var bw = document.getElementById("empClass"+emplClass).innerHTML;
//   } else {
//      var bw = 0;
//   }
   
   var bw = get_baseWage(empRow.cells[1].getAttribute("name").split(":")[2], empRow.cells[1].getAttribute("name").split(":")[1]);
   var bwCell = empRow.cells[8];
   removeKids(bwCell);
   if (typeDetails["eeBaseWage"] == "Y") {
      bwCell.innerHTML='<input type="text" class="numfld" id = "bw'+ empRow.cells[1].innerHTML + '" size="8" value="'+bw+'"/>';
      addEvent(document.getElementById('bw'+empRow.cells[1].innerHTML), 'change', calcGrid)
   } else {
      bwCell.innerHTML='<input type="text" class="numfld" id = "bw'+ empRow.cells[1].innerHTML + '" size="8" value="0" readonly/>';
   }
}

// Match up a value in an select/dropdown field to the corresponding option tag to get an attribute value from that option tag
function getOption(elm, selectedVal, attrib) {
  var childrenCnt = elm.childNodes.length, chldNode;
  if (childrenCnt > 0) {
      for (var i = 0; i < childrenCnt; i++) {
      	 chldNode = elm.childNodes[i];
	 if (chldNode.getAttribute(attrib))
	    if (chldNode.value == selectedVal) {
	    	return chldNode.getAttribute(attrib);
	    }
	 }
      }
   else
      return "0";
}

function funcChange(e) {
   e = e || window.event;
   removeKids(document.getElementById('hiddenData'));
   var unitId = document.getElementById("unitId").innerHTML.split(" ")[1];
   jsonAjax("jsonGetFuncCons", hideBW, unitId, document.getElementById("funcType").value);
   var prevCovers = document.getElementById("defCovers").innerHTML;
   var newCovers = getOption(e.target, document.getElementById("funcType").value, "covers");
   document.getElementById("defCovers").innerHTML=newCovers;
   loopGrid(function (row) {
       if (row.cells[6].childNodes[0].value == prevCovers) {
   	 row.cells[6].childNodes[0].value = newCovers;
       }
      });
   calcGrid();
}

function evalFuncChange(json) {
   var jsonFunc = eval('(' +json+ ')');
   if (jsonFunc["exists"] == "yes") {
      popup("Function Number in use (" +jsonFunc["eventNum"]+ ") has " +jsonFunc["empCnt"]+ " employees assigned.","OK");
   } else {
   }
}

function funcNumChange(e) {
   e = e || window.event;
   var unitId = document.getElementById("unitId").innerHTML.split(" ")[1];
  jsonAjax("jsonGetFuncInfo", evalFuncChange, unitId, document.getElementById("funcNumWk").value);
//  var jsonUnit = eval('(' +document.getElementById("unitData").innerHTML+ ')');
}

//function countType(gridRow) {
//  var empCnt    = gridRow.cells[0].innerHTML;
//  var gridEmpId = gridRow.cells[1].innerHTML;
//  var nameType  = gridRow.cells[2].innerHTML;
//  var empType = nameType.split(':');
//}

function saveGrid(eType) {
   document.getElementById('statusResult').innerHTML = "";
   if (document.getElementById('funcDate').value == "")
      popup("Function Date is required before saving.", "OK");
//      document.getElementById('statusResult').innerHTML = "Function Date is required before saving.";
   else
     if (document.getElementById('funcNumWk').value == "")
//        document.getElementById('statusResult').innerHTML = "Function Number for the week is required before saving.";
        popup("Function Number for the week is required before saving.", "OK");
      else
        if (document.getElementById('defCovers').innerHTML !== "0" && (document.getElementById('totCovers').value == "" || document.getElementById('totCovers').value == "0"))
//           document.getElementById('statusResult').innerHTML = "Total covers is required before saving.";
           popup("Total covers is required before saving.", "OK");
         else
//      	    if (saveFunc() == 'Saved')
            document.getElementById('statusResult').innerHTML = "Error saving function?";
      	    saveFunc2();
//               saveGrids();   // this doesn't actually execute here, look in saveFunc callback
//            else
//               document.getElementById('statusResult').innerHTML = "Error saving function.";
}

function saveFunc() {
   var qstr, unitId, eventNum;
   
   qstr = "funcDate=" + escape(document.getElementById('funcDate').value);
   qstr += "&wkendDate=" + escape(document.getElementById('wkendDate').innerHTML);
   qstr += "&roomNum=" + escape(document.getElementById('roomNum').value);
   qstr += "&funcType=" + escape(document.getElementById('funcType').value);
   qstr += "&funcGroup=" + escape(document.getElementById('funcGroup').value);
   qstr += "&funcNumWk=" + escape(document.getElementById('funcNumWk').value);
   qstr += "&foodCheck=" + escape(document.getElementById('foodCheck').value);
   qstr += "&barCheck=" + escape(document.getElementById('barCheck').value);
   qstr += "&foodBill=" + escape(document.getElementById('foodBill').value);
   qstr += "&barBill=" + escape(document.getElementById('barBill').value);
   qstr += "&foodGrat=" + escape(document.getElementById('foodGrat').value);
   qstr += "&barGrat=" + escape(document.getElementById('barGrat').value);
   qstr += "&totCovers=" + escape(document.getElementById('totCovers').value);
   qstr += "&defSetup=" + escape(document.getElementById('defSetup').value);
   qstr += "&defClear=" + escape(document.getElementById('defClear').value);
   qstr += "&defExtra=" + escape(document.getElementById('defExtra').value);

   unitId   = document.getElementById('unitId').innerHTML.split(" ")[1];
   eventNum = document.getElementById('eventNum').innerHTML;
//   xmlhttpPost2('saveFunc.php5?unitId=' + unitId + '&eventNum=' + eventNum, qstr, "statusResult", saveGrids);
   xmlhttpPost2('saveFunc.php5?unitId=' + unitId + '&eventNum=' + eventNum, qstr, "statusResult", function(){ return function(){delGrid(unitId, eventNum);}}());
}

function delGrid(unitId, eventNum) {
//	alert("Delete for unit: " +unitId+ " event: " +eventNum);
      if (eventNum == "undefined" || eventNum == "" || eventNum == "0") {
   	 document.getElementById('statusResult').innerHTML = "ERROR: Event Number Missing.  Not Saved.";
      } else {
         xmlhttpPost2a('delGrid.php5?unitId=' +unitId, "eventNum=" +eventNum, "statusResult", saveGrids2);	
      }
}

function saveGrids() {
   var empGrid = document.getElementById('empGrid');    //Get the table tag that holds the list of employees
   var eventNum = document.getElementById('eventNum').innerHTML;    //Get the table tag that holds the list of employees
   var unitId = document.getElementById('unitId').innerHTML.split(" ")[1];
   if (eventNum == "undefined" || eventNum == "" || eventNum == "0") {
   	document.getElementById('statusResult').innerHTML = "ERROR: Event Number Missing";
   } else {
      var qstr, cutFlags;
      for (var i = 1, row; row = empGrid.rows[i]; i++) {
    	document.getElementById('statusResult').innerHTML = "Still Saving: " + escape(row.cells[0].innerHTML);
//    	alert("Still Saving: " + escape(row.cells[0].innerHTML));
         qstr = "eventNum=" + escape(eventNum);
         qstr += "&empSeq=" + escape(row.cells[0].innerHTML);
         qstr += "&emplid=" + escape(row.cells[1].innerHTML);
         cutFlags = row.cells[1].getAttribute("name").split(":");
         qstr += "&eeType=" + escape(row.cells[3].childNodes[0].value);
         qstr += "&payGrp=" + escape(cutFlags[1]);
         qstr += "&emplClass=" + escape(cutFlags[2]);
         qstr += "&getSetup=" + escape(cutFlags[3]);
         qstr += "&getClear=" + escape(cutFlags[4]);
         qstr += "&getExtra=" + escape(cutFlags[5]);
         qstr += "&eeBaseWage=" + escape(cutFlags[6]);
      
         qstr += "&foodRate=" + escape(row.cells[4].innerHTML);
         qstr += "&foodGroup=" + escape(row.cells[4].getAttribute("group"));
         qstr += "&barRate=" + escape(row.cells[5].innerHTML);
         qstr += "&barGroup=" + escape(row.cells[5].getAttribute("group"));
         qstr += "&coversAllowed=" + escape(cutFlags[7]);
         qstr += "&eeCovers=" + escape(row.cells[6].childNodes[0].value);
         qstr += "&eeWeight=" + escape(row.cells[7].childNodes[0].value);
         qstr += "&baseWage=" + escape(row.cells[8].childNodes[0].value);
         qstr += "&hours=" + escape(row.cells[9].childNodes[0].value);
         qstr += "&setupAmt=" + escape(row.cells[10].childNodes[0].value);
         qstr += "&clearAmt=" + escape(row.cells[11].childNodes[0].value);
         qstr += "&extraAmt=" + escape(row.cells[12].childNodes[0].value);
         qstr += "&foodCut="  + escape(row.cells[13].childNodes[0].value);
         qstr += "&barCut="   + escape(row.cells[14].childNodes[0].value);
         qstr += "&totalPay=" + escape(row.cells[15].childNodes[0].value);
      
         xmlhttpPost2('saveGrid.php5?unitId=' + unitId, qstr, "statusResult");
      }
   }
}

function saveFunc2() {
   var qstr, unitId, eventNum;
   var empGrid = document.getElementById('empGrid');    //Get the table tag that holds the list of employees
   var eventNum = document.getElementById('eventNum').innerHTML;    //Get the table tag that holds the list of employees
   var unitId = document.getElementById('unitId').innerHTML.split(" ")[1];
   var jsonGrid = {};
   var jsonGridRow;
   
   qstr  = "&funcDate="   + escape(document.getElementById('funcDate').value);
   qstr += "&wkendDate=" + escape(document.getElementById('wkendDate').innerHTML);
   qstr += "&roomNum="   + escape(document.getElementById('roomNum').value);
   qstr += "&funcType="  + escape(document.getElementById('funcType').value);
   qstr += "&funcGroup=" + escape(document.getElementById('funcGroup').value);
   qstr += "&funcNumWk=" + escape(document.getElementById('funcNumWk').value);
   qstr += "&foodCheck=" + escape(document.getElementById('foodCheck').value);
   qstr += "&barCheck="  + escape(document.getElementById('barCheck').value);
   qstr += "&foodBill="  + escape(document.getElementById('foodBill').value);
   qstr += "&barBill="   + escape(document.getElementById('barBill').value);
   qstr += "&foodGrat="  + escape(document.getElementById('foodGrat').value);
   qstr += "&barGrat="   + escape(document.getElementById('barGrat').value);
   qstr += "&totCovers=" + escape(document.getElementById('totCovers').value);
   qstr += "&defSetup="  + escape(document.getElementById('defSetup').value);
   qstr += "&defClear="  + escape(document.getElementById('defClear').value);
   qstr += "&defExtra="  + escape(document.getElementById('defExtra').value);

   if (eventNum == "undefined" || eventNum == "" || eventNum == "0") {
   	document.getElementById('statusResult').innerHTML = "ERROR: Event Number Missing";
   } else {
      var qstr, cutFlags;
      for (var i = 1, row; row = empGrid.rows[i]; i++) {
     	 document.getElementById('statusResult').innerHTML = "Still Saving: " + escape(row.cells[0].innerHTML);
         jsonGridRow ={};
//         jsonGridRow["eventNum"]   = eventNum;
         jsonGridRow["empSeq"]     = row.cells[0].innerHTML;
         jsonGridRow["emplid"]     = row.cells[1].innerHTML;
         jsonGridRow["eeType"]     = row.cells[3].childNodes[0].value;
         cutFlags = row.cells[1].getAttribute("name").split(":");
         jsonGridRow["payGrp"]     = cutFlags[1];
         jsonGridRow["emplClass"]  = cutFlags[2];
         jsonGridRow["getSetup"]   = cutFlags[3];
         jsonGridRow["getClear"]   = cutFlags[4];
         jsonGridRow["getExtra"]   = cutFlags[5];
         jsonGridRow["eeBaseWage"] = cutFlags[6];
         jsonGridRow["foodRate"]   = row.cells[4].innerHTML;
         jsonGridRow["foodGroup"]  = row.cells[4].getAttribute("group");
         jsonGridRow["barRate"]    = row.cells[5].innerHTML
         jsonGridRow["barGroup"]   = row.cells[5].getAttribute("group");
         jsonGridRow["coversAllowed"] = cutFlags[7];
         jsonGridRow["eeCovers"]   = row.cells[6].childNodes[0].value;
         jsonGridRow["eeWeight"]   = row.cells[7].childNodes[0].value;
         jsonGridRow["baseWage"]   = row.cells[8].childNodes[0].value;
         jsonGridRow["hours"]      = row.cells[9].childNodes[0].value;
         jsonGridRow["setupAmt"]   = row.cells[10].childNodes[0].value;
         jsonGridRow["clearAmt"]   = row.cells[11].childNodes[0].value;
         jsonGridRow["extraAmt"]   = row.cells[12].childNodes[0].value;
         jsonGridRow["foodCut"]    = row.cells[13].childNodes[0].value;
         jsonGridRow["barCut"]     = row.cells[14].childNodes[0].value;
         jsonGridRow["totalPay"]   = row.cells[15].childNodes[0].value;
         jsonGrid[i] = jsonGridRow;
      }
      xmlhttpPost3('saveFunc2.php5?unitId=' +unitId+ '&eventNum=' + eventNum + qstr, jsonGrid, "statusResult");
   }
}

function saveGrids2() {
   var empGrid = document.getElementById('empGrid');    //Get the table tag that holds the list of employees
   var eventNum = document.getElementById('eventNum').innerHTML;    //Get the table tag that holds the list of employees
   var unitId = document.getElementById('unitId').innerHTML.split(" ")[1];
   var jsonGrid = {};
   var jsonGridRow;
   if (eventNum == "undefined" || eventNum == "" || eventNum == "0") {
   	document.getElementById('statusResult').innerHTML = "ERROR: Event Number Missing";
   } else {
      var qstr, cutFlags;
      for (var i = 1, row; row = empGrid.rows[i]; i++) {
     	 document.getElementById('statusResult').innerHTML = "Still Saving: " + escape(row.cells[0].innerHTML);
         jsonGridRow ={};
         jsonGridRow["eventNum"]   = eventNum;
         jsonGridRow["empSeq"]     = row.cells[0].innerHTML;
         jsonGridRow["emplid"]     = row.cells[1].innerHTML;
         jsonGridRow["eeType"]     = row.cells[3].childNodes[0].value;
         cutFlags = row.cells[1].getAttribute("name").split(":");
         jsonGridRow["payGrp"]     = cutFlags[1];
         jsonGridRow["emplClass"]  = cutFlags[2];
         jsonGridRow["getSetup"]   = cutFlags[3];
         jsonGridRow["getClear"]   = cutFlags[4];
         jsonGridRow["getExtra"]   = cutFlags[5];
         jsonGridRow["eeBaseWage"] = cutFlags[6];
         jsonGridRow["foodRate"]   = row.cells[4].innerHTML;
         jsonGridRow["foodGroup"]  = row.cells[4].getAttribute("group");
         jsonGridRow["barRate"]    = row.cells[5].innerHTML
         jsonGridRow["barGroup"]   = row.cells[5].getAttribute("group");
         jsonGridRow["coversAllowed"] = cutFlags[7];
         jsonGridRow["eeCovers"]   = row.cells[6].childNodes[0].value;
         jsonGridRow["eeWeight"]   = row.cells[7].childNodes[0].value;
         jsonGridRow["baseWage"]   = row.cells[8].childNodes[0].value;
         jsonGridRow["hours"]      = row.cells[9].childNodes[0].value;
         jsonGridRow["setupAmt"]   = row.cells[10].childNodes[0].value;
         jsonGridRow["clearAmt"]   = row.cells[11].childNodes[0].value;
         jsonGridRow["extraAmt"]   = row.cells[12].childNodes[0].value;
         jsonGridRow["foodCut"]    = row.cells[13].childNodes[0].value;
         jsonGridRow["barCut"]     = row.cells[14].childNodes[0].value;
         jsonGridRow["totalPay"]   = row.cells[15].childNodes[0].value;
         jsonGrid[i] = jsonGridRow;
      }
      xmlhttpPost3('saveGrid2.php5?unitId=' + unitId, jsonGrid, "statusResult");
   }
}

// By Staff Counts
function calc1(empGroup, totGrat, cutPercent ) {
   var empCnt, eeGrat;
   if (empGroup != "")                            //Get the group counts from the employee count frame
      empCnt   = document.getElementById('empCnt' + empGroup).innerHTML.split(':')[1];
   else
      empCnt   = 0;

   if (empCnt > 0)
       eeGrat = Math.round(parseFloat(cutPercent / empCnt * totGrat)) / 100;
   else
       eeGrat = 0;
   return eeGrat;
}

// By Covers
function calc2(totCovers, eeCovers, totGrat, cutPercent) {
   if (totCovers > 0) {
      var TPC = parseFloat(totGrat * cutPercent / 100 / totCovers);
   } else {
      var TPC = 0;
   }
   var eeGrat = Math.round(parseFloat(TPC * eeCovers * 100)) / 100;
//   alert("Tot Covers " + totCovers + " food rate " + foodRate + " bar rate " + barRate + " FTPC: " + FTPC + " BTPC: " + BTPC);
   return eeGrat;
}

function accumTots(row) {
//   var foodGrat = cells[13].childNodes[0].value;
//   var barGrat  = cells[14].childNodes[0].value;

//   document.getElementById('foodTotal').innerHTML = ;
//   document.getElementById('barTotal').innerHTML = ;
}

function gridTots() {
   var empGrid = document.getElementById('empGrid');    //Get the table tag that holds the list of employees
   var gridTots = [0,0,0];
   for (var i = 1, row; row = empGrid.rows[i]; i++) {
      gridTots[0] = gridTots[0] + parseFloat(row.cells[6].childNodes[0].value);
      gridTots[1] = gridTots[1] + parseFloat(row.cells[13].childNodes[0].value);
      gridTots[2] = gridTots[2] + parseFloat(row.cells[14].childNodes[0].value);
   }
   document.getElementById('foodTotal').innerHTML = Math.round(gridTots[1] * 100) / 100;
   document.getElementById('barTotal').innerHTML = Math.round(gridTots[2] * 100) / 100;
}

function total_grid_line(row) {
   var gridLineTot = 0;
   gridLineTot = gridLineTot + parseFloat(row.cells[8].childNodes[0].value);   //Base Wage
   gridLineTot = gridLineTot + parseFloat(row.cells[10].childNodes[0].value);  //Setup Amount
   gridLineTot = gridLineTot + parseFloat(row.cells[11].childNodes[0].value);  //Clear Amount
   gridLineTot = gridLineTot + parseFloat(row.cells[12].childNodes[0].value);  //Extra Amount
   gridLineTot = gridLineTot + parseFloat(row.cells[13].childNodes[0].value);  //Food Grat
   gridLineTot = gridLineTot + parseFloat(row.cells[14].childNodes[0].value);  //Bar Grat
   row.cells[15].childNodes[0].value = Math.round(gridLineTot * 100) / 100;
}

// This will adjust the Food gratuity allocation for the sole Net account
function netFood(row) {
   if (document.getElementById('foodGrat').value == "")
      document.getElementById('foodGrat').value = 0.00;
   if (hasClass(row.cells[4], "netAcct")) {
      var foodGrat = parseFloat(document.getElementById('foodGrat').value);
      var netAmt = parseFloat(row.cells[13].childNodes[0].value);
      var computedGrat = parseFloat(document.getElementById('foodTotal').innerHTML);
      var diffGrat = Math.round((foodGrat - computedGrat) * 100) / 100;
      var newGrat = Math.round((netAmt + diffGrat) * 100) / 100;
      row.cells[13].childNodes[0].value = newGrat;
      row.cells[13].setAttribute("title","Net adjusted by " + diffGrat);
      gridTots();
      total_grid_line(row);
   }
}

// This will adjust the Bar gratuity allocation for the sole Net account
function netBar(row) {
   if (document.getElementById('barGrat').value == "")
      document.getElementById('barGrat').value = 0.00;
   if (hasClass(row.cells[5], "netAcct")) {
      var barGrat = parseFloat(document.getElementById('barGrat').value);
      var netAmt = parseFloat(row.cells[14].childNodes[0].value);
      var computedGrat = parseFloat(document.getElementById('barTotal').innerHTML);
      var diffGrat = Math.round((barGrat - computedGrat) * 100) / 100;
      var newGrat = Math.round((netAmt + diffGrat) * 100) / 100;
      row.cells[14].childNodes[0].value = newGrat;
      row.cells[14].setAttribute("title","Net adjusted by " + diffGrat);
      gridTots();
      total_grid_line(row);
   }
}

function calcGrid(eType) {
   var empGrid = document.getElementById('empGrid');    //Get the table tag that holds the list of employees
   var compMethod, rownum, empCnt, eeType, tot, foodGrat, foodRate, foodCut, foodGrand=0, barGrat, barRate, barCut, barGrand=0, setupAmt, clearAmt, extraAmt;
   var empCnt, cutFlags, empType, tot, foodRate, foodCut, foodGrand=0, barRate, barCut, barGrand=0, setupAmt, clearAmt, extraAmt;
   var funcType = document.getElementById("funcType").value;
   var totCovers = document.getElementById('totCovers').value;
   var coversCnt=0;
   var foodNetCnt=0, barNetCnt=0;
   var foodGrat = document.getElementById('foodGrat').value;
   var barGrat  = document.getElementById('barGrat').value;
   for (var i = 1, row; row = empGrid.rows[i]; i++) {
      var foodGroup  = row.cells[4].getAttribute("group");
      var barGroup   = row.cells[5].getAttribute("group");
      if (foodGroup != "")                            //Get the group counts from the employee count frame
         foodEmpCnt   = document.getElementById('empCnt' + foodGroup).innerHTML.split(':')[1];
      else
         foodEmpCnt   = 0;
      if (barGroup != "")
         barEmpCnt    = document.getElementById('empCnt' + barGroup).innerHTML.split(':')[1];
      else
         barEmpCnt   = 0;

      eeType = row.cells[3].childNodes[0].value;
      foodRate = row.cells[4].innerHTML;
      if (hasClass(row.cells[4], "netAcct"))
         foodNetCnt++;
      barRate  = row.cells[5].innerHTML;
      if (hasClass(row.cells[5], "netAcct"))
         barNetCnt++;
      eeCovers = row.cells[6].childNodes[0].value;
      coversCnt=coversCnt+parseFloat(eeCovers);
      eeWeight = parseFloat(row.cells[7].childNodes[0].value);
      tot = 0  + parseFloat(row.cells[8].childNodes[0].value);
      setupAmt = parseFloat(row.cells[10].childNodes[0].value);
      clearAmt = parseFloat(row.cells[11].childNodes[0].value);
      extraAmt = parseFloat(row.cells[12].childNodes[0].value);
      
      compMethod = get_calc_method(funcType, eeType, "food");
      foodCut = 0;
      if (compMethod == "1") 
         foodCut = calc1(foodGroup, foodGrat, foodRate);
      if (compMethod == "2") 
         foodCut = calc2(totCovers, eeCovers, foodGrat, foodRate);
      foodCut *= eeWeight;
      row.cells[13].childNodes[0].value = foodCut;
      
      compMethod = get_calc_method(funcType, eeType, "bar");
      barCut = 0;
      if (compMethod == "1") 
         barCut = calc1(barGroup, barGrat, barRate);
      if (compMethod == "2") 
         barCut = calc2(totCovers, eeCovers, foodGrat, foodRate);
      barCut *= eeWeight;
      row.cells[14].childNodes[0].value = barCut;
      
      tot      = Math.round((parseFloat(tot) + foodCut) * 100) / 100;
      tot      = Math.round((parseFloat(tot) + barCut) * 100) / 100;
      foodGrand = Math.round((foodGrand + foodCut) * 100) / 100;
      barGrand  = Math.round((barGrand  + barCut) * 100) / 100;
      if (setupAmt > 0)
         tot = Math.round((tot + setupAmt) * 100) / 100;
      if (clearAmt > 0)
         tot = Math.round((tot + clearAmt) * 100) / 100;
      if (extraAmt > 0)
         tot = Math.round((tot + extraAmt) * 100) / 100;
      row.cells[15].childNodes[0].value = tot;
   }
   document.getElementById('foodTotal').innerHTML = foodGrand;
   document.getElementById('barTotal').innerHTML  = barGrand;
//   alert("food net: "  + foodNetCnt + " bar: " + barNetCnt);
   if (foodNetCnt == 1) {
      loopGrid(netFood);
   } else {
      if (foodNetCnt > 1) {
          popup("Warning: More than 1 payee is a Net Food Account, no Net allocated.", "OK");
      }
   }
   if (barNetCnt == 1) {
      loopGrid(netBar);
   } else {
      if (barNetCnt > 1) {
          popup("Warning: More than 1 payee is a Net Bar Account, no Net allocated.", "OK");
      }
   }
   var foodDiff = Math.round((foodGrand - foodGrat) * 100) / 100;
   var barDiff = Math.round((barGrand - barGrat) * 100) / 100;
   if (foodDiff > 5) {
       popup("Warning: Food gratuity disbursement is $" +foodDiff+ " over.", "OK");
   }
   if (barDiff > 5) {
       popup("Warning: Bar gratuity disbursement is $" +barDiff+ " over.", "OK");
   }
   if (coversCnt > totCovers) {
       popup("Warning: Total number of covers (" +coversCnt+ ") exceeds Total Covers.", "OK");
   }
  gridTots(); 
}

function loopGrid2() {
   var empGrid = document.getElementById('empGrid');    //Get the table tag that holds the list of employees
   var eeWeight, nameType, eeTypeDescr, foodGroup, barGroup, fnd="N", empCnts={}, empCnts2={}, grdFld;
   for (var i = 1, row; row = empGrid.rows[i]; i++) {
      eeWeight = parseFloat(row.cells[7].childNodes[0].value);
      grdFld=document.getElementById("eeType"+row.cells[1].innerHTML);
      eeTypeDescr = getOption(grdFld, grdFld.value, "etd");
      //row.cells[3].innerHTML;
      foodGroup   = row.cells[4].getAttribute("group");
      barGroup    = row.cells[5].getAttribute("group");
//      if (empCnts.hasOwnProperty(eeTypeDescr)) {
//         empCnts[eeTypeDescr] = empCnts[eeTypeDescr] + eeWeight;
//         }
//      else {
//         empCnts[eeTypeDescr] = eeWeight;
//      }

//      alert("Count food group: " + foodGroup + " and bar group: " + barGroup + " for emp type: " + eeTypeDescr);
   // {foodGroup :{Cnt: x, eeTypeDescr1: x1, eeTypeDescr2: x2, ... }}
      if (foodGroup != "") {
         if (empCnts2.hasOwnProperty(foodGroup)) {
            empCnts2[foodGroup]["Cnt"] = empCnts2[foodGroup].Cnt + eeWeight;
            }
         else {
            empCnts2[foodGroup] = {};
            empCnts2[foodGroup].Cnt = eeWeight;
         }
         if (empCnts2[foodGroup].hasOwnProperty(eeTypeDescr))
            empCnts2[foodGroup][eeTypeDescr] = empCnts2[foodGroup][eeTypeDescr] + eeWeight;
         else
            empCnts2[foodGroup][eeTypeDescr] = eeWeight;
      }
      if (barGroup != foodGroup)
         if (barGroup != "") {
            if (empCnts2.hasOwnProperty(barGroup)) {
               empCnts2[barGroup]["Cnt"] = empCnts2[barGroup].Cnt + eeWeight;
               }
            else {
               empCnts2[barGroup] = {};
               empCnts2[barGroup].Cnt = eeWeight;
            }
            if (empCnts2[barGroup].hasOwnProperty(eeTypeDescr))
               empCnts2[barGroup][eeTypeDescr] = empCnts2[barGroup][eeTypeDescr] + eeWeight;
            else
               empCnts2[barGroup][eeTypeDescr] = eeWeight;
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
     addClass(empRow, 'picked');
     removeClass(empRow, 'notPicked');
     var eeObj=buildEeObj(empRow);
     addToGrid(eeObj);
  }
  calcGrid();
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

function setGridRow(empObj, rowNum) {
  var emplid, baseWage, chld, chld2, json, isFoodNet, isBarNet;
  var empGrid = document.getElementById('empGrid');    //Get the table tag that holds the list of employees

  var thisRowNum, nextRow = empGrid.rows.length;
  var newrow=empGrid.insertRow(rowNum);

  var cutFlags;

  var newcell=newrow.insertCell(0);
  thisRowNum = rowNum;  // - 1;  //minus 1 for header
  newcell.innerHTML="" + thisRowNum;

  newcell=newrow.insertCell(1);
  newcell.innerHTML=empObj["emplid"];
  newcell.setAttribute("id", "grid"+empObj["emplid"]);
  //                                       0                        1                        2                           3                          4                         5                          6                              7                                8 
  newcell.setAttribute("name",""+empObj["eeType"] + ":" + empObj["payGrp"] + ":" + empObj["emplClass"] + ":" + empObj["getSetup"] + ":" + empObj["getClear"] + ":" + empObj["getExtra"] + ":" + empObj["eeBaseWage"] + ":" + empObj["coversAllowed"]);
//  newcell.setAttribute("name",""+empObj["eeType"] + ":" + empObj["payGrp"] + ":" + empObj["emplClass"] + ":" + empObj["getSetup"] + ":" + empObj["getClear"] + ":" + empObj["getExtra"] + ":" + empObj["eeBaseWage"] + ":" + empObj["coversAllowed"] + ":" + empObj["compMethod"]);

//  var nameType = empElm.html().split(':');

  newcell=newrow.insertCell(2);
  newcell.innerHTML=empObj["name"];

  newcell=newrow.insertCell(3);
  chld=document.createElement("select");
  chld.setAttribute("id","eeType"+empObj["emplid"]);
//  chld.setAttribute("type","text");   not needed, bombs IE
  chld.setAttribute("value",empObj["eeType"]);
  json =  eval('(' +document.getElementById("empTypeOpts").innerHTML+ ')');
  for (var eeType in json) {
  	chld2=document.createElement("option");
  	chld2.setAttribute("value",eeType);
  	chld2.innerHTML=json[eeType]["eeTypeDescr"];
  	chld2.setAttribute("etd",json[eeType]["eeTypeDescr"]);
  	if (empObj["eeType"] == eeType) {
  	   chld2.setAttribute("selected","selected");
  	   isFoodNet = json[eeType]["foodNet"];
  	   isBarNet  = json[eeType]["barNet"];
//  	   alert("nets are: " +isFoodNet+ " and " + isBarNet);
  	}
  	chld.appendChild(chld2);
  }
  addEvent(chld, "change", updEeDets);
  newcell.appendChild(chld);
//  newcell.innerHTML=empObj["eeTypeDescr"];

  newcell=newrow.insertCell(4);     //food rate
  newcell.innerHTML=empObj["foodRate"];
  newcell.setAttribute("group",empObj["foodGroup"]);
  if (isFoodNet == "Y") {
     newcell.setAttribute("class","netAcct");
     newcell.setAttribute("title","This is a net account.");
  }

  newcell=newrow.insertCell(5);     //bar rate
  newcell.innerHTML=empObj["barRate"];
  newcell.setAttribute("group",empObj["barGroup"]);
  if (isBarNet == "Y") {
     newcell.setAttribute("class","netAcct");
     newcell.setAttribute("title","This is a net account.");
  }

  newcell=newrow.insertCell(6);
  if (empObj["coversAllowed"] == "Y") {
     newcell.innerHTML=newcell.innerHTML='<input type="text" class="numfld" id = "bw'+ empObj["emplid"] + '" size="8" value="' +empObj["eeCovers"]+ '"/>';
  } else {
     newcell.innerHTML=newcell.innerHTML='<input type="text" class="numfld" id = "bw'+ empObj["emplid"] + '" size="8" value="0"/>';
  } 	

  newcell=newrow.insertCell(7);
  newcell.innerHTML=newcell.innerHTML='<input type="text" class="numfld" id = "ew'+ empObj["emplid"] + '" size="3" value="' +empObj["eeWeight"]+ '"/>';

  newcell=newrow.insertCell(8);     //Base Wage
  if (empObj["eeBaseWage"] == "Y") {
    newcell.innerHTML='<input type="text" class="numfld" id = "bw'+ empObj["emplid"] + '" size="8" value="'+empObj["baseWage"]+'"/>';
     addEvent(document.getElementById('bw'+empObj["emplid"]), 'blur', calcGrid)
  } else {
     newcell.innerHTML='<input type="text" class="numfld" id = "bw'+ empObj["emplid"] + '" size="8" value="0" readonly/>';
     newcell.id="bw" +thisRowNum;
  }

  newcell=newrow.insertCell(9);     //Default Hours
  newcell.innerHTML='<input type="text" class="numfld" size="2" value="'+empObj["hours"] + '"/>';

  newcell=newrow.insertCell(10);     //Default Setup
  if (empObj["getSetup"] == "Y") {
     newcell.innerHTML='<input type="text" class="numfld" id = "ds'+ empObj["emplid"] + '" size="5"  value="'+empObj["setupAmt"] + '"/>';
     addEvent(document.getElementById('ds'+empObj["emplid"]), 'blur', calcGrid)
  }   else
     newcell.innerHTML='<input type="text" class="numfld" size="5"  value="0"/>';

  newcell=newrow.insertCell(11);     //Default Clear
  if (empObj["getClear"] == "Y") {
     newcell.innerHTML='<input type="text" class="numfld" id = "dc'+ empObj["emplid"] + '" size="5" value="'+empObj["clearAmt"] + '"/>';
     addEvent(document.getElementById('dc'+empObj["emplid"]), 'blur', calcGrid)
  }   else
     newcell.innerHTML='<input type="text" class="numfld" size="5" value="0"/>';

  newcell=newrow.insertCell(12);    //Default Extra
  if (empObj["getExtra"] == "Y") {
     newcell.innerHTML='<input type="text" class="numfld" id = "de' + empObj["emplid"] + '" size="5" value="'+empObj["extraAmt"] + '"/>';
     addEvent(document.getElementById('de' + empObj["emplid"]), 'blur', calcGrid)
  }   else
     newcell.innerHTML='<input type="text" class="numfld" size="5" value="0"/>';

  newcell=newrow.insertCell(13);    //Food Cut
  newcell.innerHTML='<input type="text" class="numfld" size="8" value=' +empObj["foodCut"] +' readonly/>';

  newcell=newrow.insertCell(14);    //Bar Cut
  newcell.innerHTML='<input type="text" class="numfld" size="8" value=' +empObj["barCut"] +' readonly/>';

  newcell=newrow.insertCell(15);    //Total Pay
  newcell.innerHTML='<input type="text" class="numfld" size="8" value=' +empObj["totalPay"] +' readonly/>';

  updateEmpCnts();  ///???
//  calcGrid();  this is too often
}

function addToGrid(eeObj) {
  var nextRow = document.getElementById('empGrid').rows.length;   //Get length which is same as next insert row #
  setGridRow(eeObj, nextRow)
}

//  Populate the employee object (as used on the grid) with default employee type data stored in the hidden2 data area
function getEeTypeDets(eeObj) {
   var eeDetsJson = eval('(' +document.getElementById("empTypeOpts").innerHTML+ ')'); 
   var eeDets = eeDetsJson[eeObj["eeType"]];
//   for (var g in eeDets) 
//      alert(g + " is " + eeDets[g]);
//   eeObj["emplClass"]=eeDets["emplClass"];    this comes from EE
   eeObj["getSetup"]=eeDets["getSetup"];
   eeObj["getClear"]=eeDets["getClear"];
   eeObj["getExtra"]=eeDets["getExtra"];
   eeObj["foodRate"]=eeDets["foodTipPercent"];
   eeObj["foodGroup"]=eeDets["foodGroup"];
   eeObj["barRate"]=eeDets["barTipPercent"];
   eeObj["barGroup"]=eeDets["barGroup"];
   eeObj["coversAllowed"]=eeDets["coversAllowed"];
   eeObj["eeBaseWage"]=eeDets["eeBaseWage"];
   if (eeObj["emplClass"] && eeObj["payGrp"])
      eeObj["baseWage"] = get_baseWage(eeObj["emplClass"], eeObj["payGrp"]);
   else
      eeObj["baseWage"] = 0;
//   if (document.getElementById("empClass"+eeObj["emplClass"])) 
//      eeObj["baseWage"] = document.getElementById("empClass"+eeObj["emplClass"]).innerHTML;
//   else
//      eeObj["baseWage"]=0;
   eeObj["hours"]=eeDets["defHours"];
   eeObj["compMethod"]=eeDets["compMethod"];
   if (eeObj["coversAllowed"] == "Y")
      eeObj["eeCovers"] = document.getElementById('defCovers').innerHTML;
   else 
      eeObj["eeCovers"] = 0;
}

function updEeDets(e) {
   e = e || window.event;
   var elm=e.target;
   var re=/^eeType(\w+)/g;
   var str = elm.id;
//   var matches=str.match(re);
   var matches=re.exec(str);
//   alert("Matched len: " + matches.length);
   emplid = matches[1];
//   alert("match 0: " + matches[0]);
//   alert("match 1: " + matches[1]);
   var currIdx = elm.parentNode.parentNode.rowIndex;
   var currRow = document.getElementById("empGrid").rows[currIdx];
   var eeObj= buildEeObjGrid(currRow);
   eeObj["eeType"]=elm.value;
   getEeTypeDets(eeObj)
//   for (var g in eeObj) 
//      alert(g + " is " + eeObj[g]);
    document.getElementById("empGrid").deleteRow(currIdx);
    setGridRow(eeObj, currIdx);
    calcGrid();
}

// Build a JSON object for the employee grid for the employee from the employee list as passed in the the id reference.
function buildEeObj(idEmplid) {
   var eeObj = {}, cutFlags;
   var defSetup = document.getElementById('defSetup').value;
   var defClear = document.getElementById('defClear').value;
   var defExtra = document.getElementById('defExtra').value;

   eeObj["unitId"]=document.getElementById("unitId").innerHTML.split(" ")[1];
   eeObj["eventNum"]=document.getElementById("eventNum").innerHTML;
   eeObj["empSeq"]=0;
   eeObj["emplid"]=idEmplid.getAttribute("id");
   eeObj["name"]=idEmplid.innerHTML.split(":")[0];
   eeObj["eeType"]=idEmplid.getAttribute("name").split(":")[0];
   eeObj["payGrp"]=idEmplid.getAttribute("name").split(":")[1];
   eeObj["emplClass"]=idEmplid.getAttribute("name").split(":")[2];
   getEeTypeDets(eeObj); 
   eeObj["eeCovers"]=document.getElementById('defCovers').innerHTML;
   eeObj["eeWeight"]=1;
   if (eeObj["getSetup"] == "Y") {
     eeObj["setupAmt"]=defSetup;
   } else {
     eeObj["setupAmt"]=0;
   }
   if (eeObj["getClear"] == "Y") {
     eeObj["clearAmt"]=defClear;
   } else {
     eeObj["clearAmt"]=0;
   }
   if (eeObj["getExtra"] == "Y") {
     eeObj["extraAmt"]=defExtra;
   } else {
     eeObj["extraAmt"]=0;
   }
   eeObj["foodCut"]=0;
   eeObj["barCut"]=0;
   eeObj["totalPay"]=0;
   return eeObj;
}

// Build a JSON object for the employee grid for the employee from the grid as passed in the the row reference.
function buildEeObjGrid(gridRow) {
   var eeObj = {}, cutFlags;

   eeObj["unitId"]=document.getElementById("unitId").innerHTML.split(":")[1];
   eeObj["eventNum"]=document.getElementById("eventNum").innerHTML;
   eeObj["empSeq"]=gridRow.cells[0].innerHTML;
   eeObj["emplid"]=gridRow.cells[1].innerHTML;
   eeObj["name"]=gridRow.cells[2].innerHTML;
   cutFlags=gridRow.cells[1].getAttribute("name").split(":");
   eeObj["eeType"]=cutFlags[0];
   eeObj["payGrp"]=cutFlags[1];
   eeObj["emplClass"]=cutFlags[2];
   eeObj["getSetup"]=cutFlags[3];
   eeObj["getClear"]=cutFlags[4];
   eeObj["getExtra"]=cutFlags[5];
   eeObj["eeBaseWage"]=cutFlags[6];
   eeObj["coversAllowed"]=cutFlags[7];
   eeObj["compMethod"]=cutFlags[8];

//   eeObj["eeTypeDescr"]=idEmplid.innerHTML.split(":")[1];
   
   eeObj["foodRate"]=gridRow.cells[4].innerHTML;
   eeObj["foodGroup"]=gridRow.cells[4].getAttribute("group");
   eeObj["barRate"]=gridRow.cells[5].innerHTML;
   eeObj["barGroup"]=gridRow.cells[5].getAttribute("group");
   
   eeObj["eeCovers"]=gridRow.cells[6].childNodes[0].value;
   eeObj["eeWeight"]=gridRow.cells[7].childNodes[0].value;
   eeObj["baseWage"]=gridRow.cells[8].childNodes[0].value;
   eeObj["hours"]=gridRow.cells[9].childNodes[0].value;
   
   if (eeObj["getSetup"] == "Y") {
     eeObj["setupAmt"]=gridRow.cells[10].childNodes[0].value;
   } else {
     eeObj["setupAmt"]=0;
   }
   if (eeObj["getClear"] == "Y") {
     eeObj["clearAmt"]=gridRow.cells[11].childNodes[0].value;
   } else {
     eeObj["clearAmt"]=0;
   }
   if (eeObj["getExtra"] == "Y") {
     eeObj["extraAmt"]=gridRow.cells[12].childNodes[0].value;
   } else {
     eeObj["extraAmt"]=0;
   }
   eeObj["foodCut"] =gridRow.cells[13].childNodes[0].value;
   eeObj["barCut"]  =gridRow.cells[14].childNodes[0].value;
   eeObj["totalPay"]=gridRow.cells[15].childNodes[0].value;
   return eeObj;
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
function loadEeGrid(eventNum, unitId) {
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

          addToGrid(json);
          }
      popright("getEes",unitId)
//      loopGrid(eeGridSel);     //Id those that are selected   wmr
      calcGrid();
      }
   }
   xmlhttp.open("GET","jsonFuncEmps.php5?eventNum="+eventNum+"&unitId="+unitId,true);
   xmlhttp.send();
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
  	addToGrid(eeObj);
  	chooseEe(event.target);
  	for (var p in eeObj) {
//  	   alert(p + ':' + eeObj[p]);
  	}
  	calcGrid();
  }

  var unicode=event.keyCode? event.keyCode : event.charCode;
}

function loadEeList(e) {
   e = e || window.event;
    alert('butt');
    //popright("getEes",unitId);
}

function lettScroll(e) {
   e = e || window.event;
   var theScroll = document.getElementById('empListing');
//   alert("Height: " + theScroll.scrollHeight+ " Client:" +theScroll.clientHeight);
   theScroll.scrollTop=e.target.getAttribute('letter') *  theScroll.scrollHeight / 290.09; 22  * 23.4;	 //about 9 names
}

function set_events2(){
   $(".multiVal").click(function(event) {
            selectee(event); });
   var chld, jumpLetters = document.getElementById('empAlphas');
   var childrenCnt = jumpLetters.childNodes.length;
   if (childrenCnt > 0) {
       for (var i = 0; i < childrenCnt; i++) {
       	 chldNode = jumpLetters.childNodes[i];
	       if (chldNode.getAttribute('letter'))
	           addEvent(chldNode, 'click', lettScroll);
       }
   }
   else
      return "0";
   addEvent(document.getElementById('waitButton'),'click',loadEeList);
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
      addClass(document.getElementById("todoform"),'listarea');
      var empList = eval('(' +xmlhttp.responseText+ ')');
      for (var empVal in empList) {
      	  json = empList[empVal];

          setEeSumm(json);
          }
      }
   }
   xmlhttp.open("GET","jsonEmpSumm.php5?unitId="+unitId,true);
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
  var outGrid = document.getElementById('listGrid');    //Get the table tag that holds the list of employees

  var emplid, thisRowNum, nextRow = outGrid.rows.length;
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
   var xmlhttp, json, newrow, newcell, formDiv, empData;
   formDiv=document.getElementById("todoform");
   var childrenCnt = formDiv.childNodes.length;
   if (childrenCnt > 0) {
       while (formDiv.hasChildNodes()){
	  formDiv.removeChild(formDiv.firstChild);
	}
    }
   if (window.XMLHttpRequest) {
      xmlhttp=new XMLHttpRequest();
   } else {
      xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
   }
   xmlhttp.onreadystatechange=function() {
   if (xmlhttp.readyState==4 && xmlhttp.status==200) {
      var empList = eval('(' +xmlhttp.responseText+ ')');
      var t = document.createElement('div');
      t.setAttribute("id", "listHeads");
      t.innerHTML=empList["1"]["emplid"] +":&nbsp"+ empList["1"]["name"];
      formDiv.appendChild(t);
      t = document.createElement('table');
      t.setAttribute("id", "listGrid");
      formDiv.appendChild(t);
      eeDetsHead(t);
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
   xmlhttp.open("GET","jsonEmpDetsWk.php5?unitId="+unitId+"&emplid="+emplid,true);
   xmlhttp.send();
}

function eeDetsHead(outGrid) {
  var newrow=outGrid.insertRow(0);

  var newcell=newrow.insertCell(0);
  newcell.innerHTML="Row";
  newcell.setAttribute("class", "summhead");
//  var newcell=newrow.insertCell(1);
// newcell.innerHTML="Emplid";
//  newcell.setAttribute("class", "summhead");
//  var newcell=newrow.insertCell(2);
//  newcell.innerHTML="Name";
//  newcell.setAttribute("class", "summhead");
  var newcell=newrow.insertCell(1);
  newcell.innerHTML="Position";
  newcell.setAttribute("class", "summhead");
  var newcell=newrow.insertCell(2);
  newcell.innerHTML="Func date";
  newcell.setAttribute("class", "summhead");
  var newcell=newrow.insertCell(3);
  newcell.innerHTML="Func Type";
  newcell.setAttribute("class", "summhead");
  var newcell=newrow.insertCell(4);
  newcell.innerHTML="Base Wage";
  newcell.setAttribute("class", "summhead");
  var newcell=newrow.insertCell(5);
  newcell.innerHTML="Hours";
  newcell.setAttribute("class", "summhead");
  var newcell=newrow.insertCell(6);
  newcell.innerHTML="Setup";
  newcell.setAttribute("class", "summhead");
  var newcell=newrow.insertCell(7);
  newcell.innerHTML="Clear";
  newcell.setAttribute("class", "summhead");
  var newcell=newrow.insertCell(8);
  newcell.innerHTML="Extra";
  newcell.setAttribute("class", "summhead");
  var newcell=newrow.insertCell(9);
  newcell.innerHTML="Food";
  newcell.setAttribute("class", "summhead");
  var newcell=newrow.insertCell(10);
  newcell.innerHTML="Bar";
  newcell.setAttribute("class", "summhead");
  var newcell=newrow.insertCell(11);
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

//  newcell=newrow.insertCell(1);
//  newcell.innerHTML=summObj["emplid"];

//  newcell=newrow.insertCell(2);
//  newcell.innerHTML=summObj["name"];

  newcell=newrow.insertCell(1);
  newcell.innerHTML=summObj["eeTypeDescr"];

  newcell=newrow.insertCell(2);
  newcell.innerHTML=summObj["funcDate"];

  newcell=newrow.insertCell(3);
  newcell.innerHTML=summObj["funcDescr"];

  newcell=newrow.insertCell(4);
  newcell.innerHTML=summObj["sumBaseWage"];
  newcell.setAttribute("class", "summfld");

  newcell=newrow.insertCell(5);
  newcell.innerHTML=summObj["sumHours"];
  newcell.setAttribute("class", "summfld");

  newcell=newrow.insertCell(6);
  newcell.innerHTML=summObj["sumSetup"];
  newcell.setAttribute("class", "summfld");

  newcell=newrow.insertCell(7);
  newcell.innerHTML=summObj["sumClear"];
  newcell.setAttribute("class", "summfld");

  newcell=newrow.insertCell(8);
  newcell.innerHTML=summObj["sumExtra"];
  newcell.setAttribute("class", "summfld");

  newcell=newrow.insertCell(9);
  newcell.innerHTML=summObj["sumFood"];
  newcell.setAttribute("class", "summfld");

  newcell=newrow.insertCell(10);
  newcell.innerHTML=summObj["sumBar"];
  newcell.setAttribute("class", "summfld");

  newcell=newrow.insertCell(11);
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
   xmlhttp.open("GET","jsonGetFuncsWk.php5?unitId="+unitId,true);
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
  anch.setAttribute("unitid", summObj["unitId"]);
  anch.setAttribute("eventnum", summObj["eventNum"]);
//  anch.setAttribute("onclick","loadFunc('" +summObj["unitId"]+ "','" +summObj["eventNum"]+ "'); return false;");
  anch.onclick = function(e){e = e || window.event; loadFunc(e); return false;};
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

// Report the function currently on screen
function func_report() {
   var unitId = document.getElementById('unitId').innerHTML.split(" ")[1];
   var eventNum = document.getElementById('eventNum').innerHTML;
   window.open("./weekReports.php5?unitId="+unitId+"&eventNum="+eventNum);
}

function toggle_block(div_id) {
	var el = document.getElementById(div_id);
	if ( el.style.display == 'none' ) {	el.style.display = 'block';}
	else {el.style.display = 'none';}
}

function pop_button1(e) {
       e = e || window.event;
	toggle_block("modal");
	toggle_block("popup_div");
	disp_popup.popList.shift();
	if (disp_popup.popList.length > 0) 
	    disp_popup();
}

function popup(textMsg, butt1Text, butt2Text) {
   if (disp_popup.popList) {
   	disp_popup.popList.push({"textMsg":textMsg, "butt1Text":butt1Text, "butt2Text":butt2Text});
   } else {
   	disp_popup.popList = [{"textMsg":textMsg, "butt1Text":butt1Text, "butt2Text":butt2Text}];
   }
   if (disp_popup.popList.length == 1) {
      disp_popup();
   }
}

function disp_popup() { // textMsg, butt1Text, butt2Text) {
   var msgObj = disp_popup.popList[0];
   var textMsg = msgObj["textMsg"];
   var butt1Text = msgObj["butt1Text"];
   var butt2Text = msgObj["butt2Text"];
   modal=document.getElementById("modal");
   modal.style.display='block';
   var popDiv=document.getElementById("popup_div");   //Get the popup div
   removeKids(popDiv);                                //remove current content
   var popText=document.createElement("p");           //create new content
   popText.innerHTML=textMsg;
   popDiv.appendChild(popText);
   var butt1=document.createElement("input");
   butt1.setAttribute("id","popbutt1");
   butt1.setAttribute("value",butt1Text);
   butt1.setAttribute("type","button");
   popDiv.appendChild(butt1);
   if (butt2Text == "undefined") {
      var butt2=document.createElement("input");
      butt2.setAttribute("id","popbutt2");
      butt2.setAttribute("value",butt2Text);
      butt2.setAttribute("type","button");
      popDiv.appendChild(butt2);
   }
   addEvent(document.getElementById('popbutt1'), 'click', pop_button1);
   if (butt2Text == "undefined") {
      addEvent(document.getElementById('popbutt2'), 'click', pop_button1);
   }
   popDiv.style.display='block';
}