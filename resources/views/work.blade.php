@extends('layouts.app')

@section('content')
<p id="demo"></p>

        <div class="container bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
            <div class="row">
                <div class="col">
                    <select id="fdev">
                        <optgroup label="Device Number">
                            @if(isset($devnum))
                                @foreach ($devnum as $item)
                                    <option value="{{ $item->number }}">{{ $item->number }}</option>
                                @endforeach
                            @endif
                        </optgroup>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="row">
                        <div class="col">
                            <h1>Ring</h1>
                        </div>
                    </div>

                    <dev id="ring"></dev>

                    <div class="row">
                        <div class="col-xl-11">
                            <form id="uri-form" onsubmit="return check(event)">
                                @csrf
                                <input id="fURL" class="form-control input-lg" type="url" placeholder="enter url video file" />
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="row">
                        <div class="col">
                            <h1>Uploaded</h1>
                        </div>
                    </div>

                    <dev id="upload"></dev>

                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="alert">
                        <div class="progress">
                            <div class="progress-bar" id="pbar" role="progressbar" style="width: 0%;" aria-valuenow="35" aria-valuemin="0" aria-valuemax="100">uploading</div>
                        </div>                    
                    </div>
                </div>
            </div>
        </div>

<script>
const check = (e) => {
    var data = new FormData();
    data.append('_token', document.getElementById('uri-form').elements['_token'].value);
    data.append('url', document.getElementById('fURL').value);
    data.append('dev', $("#fdev option:selected").text());
    var xhr = new XMLHttpRequest();
    xhr.open('POST', '/web', true);
    xhr.onload = function () { 
//        alert(this.responseText); 
    };
    xhr.send(data);
    document.getElementById('fURL').value=''
    return false;
};


function ringclk(a) {
    var data = new FormData();
    data.append('_token', document.getElementById('uri-form').elements['_token'].value);
    data.append('id', a);
    var xhr = new XMLHttpRequest();
    xhr.open('POST', '/delring', true);
    xhr.onload = function () {
//        document.getElementById('demo').innerHTML = this.responseText;////////////////////// debug
    };
    xhr.send(data);
}

function uploadclk(a) {
    var data = new FormData();
    data.append('_token', document.getElementById('uri-form').elements['_token'].value);
    data.append('id', a);
    var xhr = new XMLHttpRequest();
    xhr.open('POST', '/delupload', true);
    xhr.onload = function () {
 //       document.getElementById('demo').innerHTML = this.responseText;////////////////////  debug
    };
    xhr.send(data);
}


function update()
{
    var h1 = '<div class="row"><div class="col" style="text-align: right;"><button class="btn btn-'
    var h2 = ' float-right" type="button" style="text-align: right;" onclick="ringclk('
    var h2_ = ' float-right" type="button" style="text-align: right;" onclick="uploadclk('
    var h3 = ')">X</button><p style="text-align: left;margin-top: 5px;">';
    var h4 = '</p></div></div>';
    var data = new FormData();
    data.append('_token', document.getElementById('uri-form').elements['_token'].value);
    data.append('dev', $("#fdev option:selected").text());
    var xhr = new XMLHttpRequest();
    xhr.open('POST', '/getring', true);
    xhr.onload = function () { 
        var progress = 0;
        var name = "";
        var block = "";
        const obj = JSON.parse(this.responseText); 
        obj.forEach(function(elem){block += h1+(elem.status == 101 ? 'warning' : 'primary')+h2+"'"+elem.id+"'"+h3+elem.url+h4; if (elem.status > 0 && elem.status <= 100) {progress = elem.status; name = elem.url;}});
        if (block != document.getElementById('ring').innerHTML)
            document.getElementById('ring').innerHTML = block;
        document.getElementById("pbar").style.width = progress+'%';
        document.getElementById("pbar").innerHTML = name;
    };
    xhr.send(data);

    var xhr2 = new XMLHttpRequest();
    xhr2.open('POST', '/getupload', true);
    xhr2.onload = function () { 
        var block = "";
        const obj = JSON.parse(this.responseText); 
        obj.forEach(function(elem){block += h1+(elem.status == 1 ? 'danger' : 'primary')+h2_+"'"+elem.id+"'"+h3+elem.url+h4;});
        if (block != document.getElementById('upload').innerHTML)
            document.getElementById('upload').innerHTML = block;
    };
    xhr2.send(data);

}

setTimeout(function run() 
{
    update();
    setTimeout(run, 1000);
}, 1000);



</script>

@endsection
