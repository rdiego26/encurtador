function submitForm()
{
	document.frm_encurtador.submit();
}

function ValidaURL(url) {
var regex = /^(([\w]+:)?\/\/)?(([\d\w]|%[a-fA-f\d]{2,2})+(:([\d\w]|%[a-fA-f\d]{2,2})+)?@)?([\d\w][-\d\w]{0,253}[\d\w]\.)+[\w]{2,4}(:[\d]+)?(\/([-+_~.\d\w]|%[a-fA-f\d]{2,2})*)*(\?(&?([-+_~.\d\w]|%[a-fA-f\d]{2,2})=?)*)?(#([-+_~.\d\w]|%[a-fA-f\d]{2,2})*)?$/;
  return regex.test(url);
}

function validar(url_recebida) {
  alert(url_recebida);
  
  if(!ValidaURL(url_recebida))
  {
  return false;
  }
  return true;
}
