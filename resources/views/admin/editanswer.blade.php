@extends('layouts.main')
@section('head.title')
Cập nhật đáp án
@endsection
@section('head.css')
<style>
	textarea{
		height: 3em;
	}
</style>
@endsection
@section('body.content')
	<div class="container-fluid">
		<ul class="list-group">
			@if ($Photo != null)
			<li class="list-group-item">
				<img class='img-responsive' src="{{'/images/imageQuestion/' . $Photo}}" />
			</li>
			@endif

		</ul>
		<h1 class="title">Thêm câu trả lời mới</h1>
		<h2>Câu hỏi phát âm => Bôi đen + Click Gạch chân</h2>
			{!! Form::open(['method' => 'PUT', 'name' => 'editAnswerForm', 'route' => ['answer.update', $QuestionID],'class'=>'control-label']) !!}
			
			<div class="form-group">
				{!! Form::label('Detail', 'Câu trả lời: ',['class'=>'control-label']) !!}
					<script type="text/javascript">
					var count = -1;
					var minAnswer = {{count($Answers)}};
					if (minAnswer == 0){
						minAnswer = 4;
					}
					var resultQuestion = -1;

					function ob(x){
						return document.getElementById(x);
					}

					function xoa(x){
						ob('answers').removeChild(ob(x));
						var o = x.substring(x.indexOf('divanswer') + 'disanswer'.length);
						updateID();
					}

					function updateID(){
						var answers = ob('answers');
						var childrens = answers.children;
						if (childrens == null){
							return;
						}
						ob('count').value = count = childrens.length - 1;
						resultQuestion = -1;
						// childrens[0] is <script> element
						// childrens[1->n] are <div> element
						for(var i = 1; i < childrens.length; i++){
							var div = childrens[i];
							div.id = 'divanswer' + i;

							// children[0] is textarea hold answer detail
							div.children[0].id = 'answer' + i;
							div.children[0].setAttribute('name', div.children[0].id);

							// children[3] is a reserved textarea
							div.children[3].id = 'ta_answer' + i;
//                            div.children[3].setAttribute('name', div.children[0].id);

							// children[1] is a radio button
							var radio = div.children[1];
							radio.id = 'radio' + i;
							if (radio.checked){
								resultQuestion = i;
							}
							div.setAttribute('class','div_i');
							div.children[0].setAttribute('class','col-sm-12');
							radio.setAttribute('class','checked');
							radio.setAttribute('type','radio');
							div.children[2].setAttribute('class','btn btn-danger');
//                            radio.setAttribute('onclick', 'markAnswer("' + radio.id + '")');
//                            if (i > minAnswer - 1)

							// children[2] is a button which allow to delete answer i.
							div.children[2].setAttribute('onclick', 'xoa("divanswer' + i + '")');
							div.children[4].setAttribute('onclick', 'addTag("u", "' + i + '")');
							console.log('finish update ' + i);
						}
						ob('result').value = resultQuestion;

					}

					function addTag(tag, id){
						var tagOpen = "[u]";
						var tagClose = "[/u]";
						var textarea = ob('answer' + id);
						var oldText = textarea.value;
						var start = textarea.selectionStart;
						var end = textarea.selectionEnd;
						if (start == end){
							return;
						}
						var before = oldText.substring(0, start);
						var after = oldText.substring(end, oldText.length);
						var content = oldText.substring(start, end);
						console.log(content);
						if ((content.indexOf(tagOpen) != -1) && (content.indexOf(tagClose) != -1)){
							console.log('giet no');
							content = content.replace(tagOpen, "");
							content = content.replace(tagClose, "");
							textarea.value = before + content + after;
							textarea.setSelectionRange(start, start + content.length);
							textarea.focus();
						}
						else {
							var newText = before + tagOpen + content + tagClose + after;
							textarea.value = newText;
							textarea.setSelectionRange(start, end + tagClose.length + tagClose.length - 1);
							textarea.focus();
						}
					}

					function markAnswer(x){
						var pos = x.substring(x.indexOf('radio') + 5);
						resultQuestion = pos;
						ob('result').value = resultQuestion;
					}

					function add(){
						var e = document.createElement('textarea');
//                        e.type = 'text';
//                        e.name = 'answer' + count;
						e.id = 'specialID';
//                        e.setAttribute('contenteditable', 'true');
//                        e.innerHTML = 'preText';
						e.setAttribute('class', 'col-sm-12');
						var divElement = document.createElement('div');
						divElement.id = "divanswer" + count;
						ob('answers').appendChild(divElement);
						divElement.appendChild(e);
						var radio = document.createElement('input');
						radio.type = 'checkbox';
						radio.name = 'radio_answer';
						divElement.appendChild(radio);
						var btnDel = document.createElement('input');
						btnDel.value = 'Xóa';
						btnDel.type = 'button';
						btnDel.setAttribute('onClick','xoa("' + divElement.id + '")');
						divElement.appendChild(btnDel);
						var hiddenTextarea = document.createElement('textarea');
						hiddenTextarea.style.display = 'none';
						divElement.appendChild(hiddenTextarea);
						var uButton = document.createElement('input');
						uButton.type = 'button';
						uButton.setAttribute('value', 'Gạch chân');
						uButton.setAttribute('class','btn btn-primary');
						divElement.appendChild(uButton);
					}

					function submitForm(){
						updateID();
						for(var i = 1; i <= count; i++){
							ob('ta_answer' + i).innerHTML = ob('answer' + i).innerHTML = ob('answer' + i).value;
						}
						if (resultQuestion > -1){
							document.editAnswerForm.submit();
						}
						else{
							alert('Chưa chọn đáp án đúng của câu hỏi.');
						}
					}
//                 </script>
				<div class="" id="div_answer">
					<input type="text" id="count" name="numAnswer" style="display: none;"/>
					<input type="text" id="result" name="resultQuestion" style="display: none;" />
					<div id="answers">
						<script type="text/javascript">
							for(var i = 0; i < minAnswer; i++){
								add();
							}
							updateID();
							{!! $index = 1 !!}
							var index = 1;
							@foreach($Answers as $a)
								ob('answer{{ $index }}').innerHTML = {!! json_encode($a['Detail']) !!};
								@if ($a['Logical'] == 1)
									ob('radio{{$index}}').checked = true;
								@endif
								{!! $index++ !!}
							@endforeach
						</script>
					</div>
					<input type="button" value="+" onclick="add(); updateID()">
				</div>
			</div>


				<input type="text" value="{{$QuestionID}}" style="display: none" readonly name="QuestionID" />
				{!! Form::button('Cập nhật',['class' => 'btn btn-primary', 'onclick' => 'submitForm()']) !!}
			{!! Form::close() !!}
		<a href="{{route('user.viewpost', $PostID)}}" class="btn btn-primary">Quay lại bài đăng</a>
		</div>


	</div>
@endsection