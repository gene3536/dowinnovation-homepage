function top2menuView(a) //2차메뉴보기
{
	if(this.id){
		eidStr = this.id;
		eidNum=eidStr.substring(eidStr.lastIndexOf("m",eidStr.length)+1,eidStr.length);
		a = parseInt(eidNum);
	}
	top2menuHideAll();
	top1Menu = document.getElementById("top1m"+a);
	top2Menu = document.getElementById("top2m"+a);
	if(a<10){ann='0'+a;} else {ann=''+a;}
	if (a==0) { //메인은2차메뉴활성화안함
	} else {
		if (top1Menu) {
			top1Menu.getElementsByTagName("img")[0].src=top1Menu.getElementsByTagName("img")[0].src.replace("_off.gif","_on.gif");
			if (top2Menu) { 
				top2Menu.style.display = 'inline';
				}
		}
	}
}
function top2menuHide(a) //2차메뉴감추기
{
	if(this.id){
		eidStr = this.id;
		eidNum=eidStr.substring(eidStr.lastIndexOf("m",eidStr.length)+1,eidStr.length);
		a = parseInt(eidNum);
	}
	//top2menuHideAll();
	top1Menu = document.getElementById("top1m"+a);
	top2Menu = document.getElementById("top2m"+a);
	top1MenuCurr = document.getElementById("top1m"+d1n);
	top2MenuCurr = document.getElementById("top2m"+d1n);
	if(a<10){ann='0'+a;} else {ann=''+a;}
	if (top1Menu) {
		top1Menu.getElementsByTagName("img")[0].src=top1Menu.getElementsByTagName("img")[0].src.replace("_on.gif","_off.gif");
		if (top2Menu) { top2Menu.style.display = 'none'; }
		
		if (top1MenuCurr) {
			top1MenuCurr.getElementsByTagName("img")[0].src = top1MenuCurr.getElementsByTagName("img")[0].src.replace("_off.gif","_on.gif");
		}
		
		if (top2MenuCurr) { 
			top2MenuCurr.style.display = 'inline';
		}
	}
}

function top2menuHideAll() //2차메뉴모두감추기
{
	top1menuEl = document.getElementById("top1menu").childNodes;
	for (i=1;i<=top1menuEl.length;i++)
	{
		top1Menu = document.getElementById("top1m"+i);
		top2Menu = document.getElementById("top2m"+i);
		if(i<10){inn='0'+i;} else {inn=''+i;}
		if (top1Menu) {
			top1Menu.getElementsByTagName("img")[0].src=top1Menu.getElementsByTagName("img")[0].src.replace("_on.gif","_off.gif");
			if (top2Menu) { top2Menu.style.display = 'none'; }
		}
	}
}

function initTopMenu(d1,d2) {
	d1n = d1;
	d2n = d2;
	d1nn = (d1n<10) ? '0'+d1n : d1n;
	d2nn = (d2n<10) ? '0'+d2n : d2n;
 	var topmenu = document.getElementById("topmenu");
	//if(topmenu) topmenu.style.background = "url(../images/top_menu_"+d1nn+"_menubg.gif) no-repeat";
 	top1menuEl = document.getElementById("top1menu").childNodes;
	
	for (i=1;i<=top1menuEl.length;i++)
	{
		top1Menu = document.getElementById("top1m"+i);
		top2Menu = document.getElementById("top2m"+i);
		if (top1Menu) {
			top1Menu.onmouseover = top1Menu.onfocus = top2menuView;
			//top1Menu.onmouseout = top2menuHide;
			if (top2Menu) { 
				top2Menu.onmouseover = top2Menu.onfocus = top2menuView;
				top2Menu.onmouseout = top2menuHide;
			}
		}
	}
	top2MenuCurrAct = document.getElementById("top2m"+d1n+"m"+d2n);
	if (top2MenuCurrAct) {
		//top2MenuCurrAct.getElementsByTagName('a')[0].className = "active";
		top2MenuCurrAct.getElementsByTagName("a")[0].style.color="#8ce8ff";
	  top2MenuCurrAct.getElementsByTagName("a")[0].style.fontWeight="bold";
	}
	top2menuHide(d1);
}