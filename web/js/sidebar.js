
function dump (sObjName, sTab) {
  var Obj = eval (sObjName);
  //
  if (sTab==null) sTab='';
  if (typeof(Obj)!='object')
    return sTab+sObjName+': '+typeof(Obj)+' = '+Obj+'\n';
  else if (Obj.length!=null)
    var sResult = sTab+sObjName+': array length '+Obj.length+'\n';
  else
    var sResult = sTab+sObjName+': object\n';
  //
  for (sProp in Obj)
    sResult += dump (sObjName+"['"+sProp+"']", sTab+'  ');
  return sResult;
}