<!--
function d(v){
	document.forms[0].p.value = v;
}

function sb(){
	document.f.submit();
	return false;
}


function reg(){

	if(!confirm("入力された内容で登録します。\nよろしいですか？")){
		return false;
	}
	document.f.submit();
	return false;
}


function main_chg(id, name){

	if(!confirm(name + "をメインカーに設定しますか？")){
		return false;
	}

	document.f.submit();

}



function go_turning(id, name){

	/*
	if(!confirm(name + "をチューニングします。\nよろしいですか？")){
		return false;
	}
	*/

	document.f.md.value = 1;
	document.f.submit();

	return false;
}

function go_turning2(){

	if(!confirm("チューニングを確定します。\nよろしいですか？")){
		return false;
	}


	document.f.md.value = 2;
	document.f.submit();

	return false;
}


function go_bosyu(){

	if(!confirm("入力された内容で練習試合を開催します。\nよろしいですか？")){
		return false;
	}

	document.f.submit();

	return false;
}


function go_entry(r_id, name){

	if(!confirm(name + "にエントリーします。\nよろしいですか？")){
		return false;
	}

	document.f.r_id.value = r_id;
	document.f.submit();

	return false;
}

function go_present(){

	document.f.md.value = 1;
	document.f.submit();

	return false;
}

function go_fri(to_id){

	if(!confirm("フレンド申請します。\nよろしいですか？")){
		return false;
	}

	document.f.to_id.value = to_id;
	document.f.submit();

	return false;
}

function gofrreg(to_id){

	if(!confirm("フレンドの承認をします。\nよろしいですか？")){
		return false;
	}

	document.f.to_id.value = to_id;
	document.f.submit();

	return false;
}



function go_kara(){

	if(document.f.name.value == ''){
		alert("店名は必須です");
		return;
	}

	if(document.f.area.value == ''){
		alert("エリアは必須です");
		return;
	}

	if(!confirm("入力された内容で登録します。\nよろしいですか？")){
		return false;
	}
	document.f.md.value = 1;
	document.f.submit();
	return false;
}


function chg_kara(){
	document.f.submit();
	return false;
}


function logout(){
	if(!confirm("ログアウトします。\nよろしいですか？")){
		return false;
	}

	document.location = 'logout.php';
	return false;
}

function cardel(url){
	if(!confirm("廃車にします。\nよろしいですか？")){
		return false;
	}

	document.location = url;
	return false;
}


function ahref(url){
	document.location = url;
	return false;
}

function nextday(){
	document.fn.nx.value = 1;
	document.fn.submit();
	return false;

}

function training(v){
	document.ft.ftmd.value = 1;
	document.ft.ftv.value = v;
	document.ft.submit();
	return false;

}


function off_entry(r){
	if(!confirm("このレースにエントリーします。\nよろしいですか？")){
		return false;
	}

	document.f.rid.value = r;
	document.f.submit();
}

-->


