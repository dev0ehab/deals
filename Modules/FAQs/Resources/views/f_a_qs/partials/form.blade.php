@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


@bsMultilangualFormTabs
    {{ BsForm::text('question')->attribute(['data-parsley-minlength' => '3']) }}
    {{ BsForm::textarea('answer')->required()->attribute('class', 'form-control')->rows(3)->attribute(['data-parsley-minlength' => '3']) }}
@endBsMultilangualFormTabs
