<style>
    .error-message{
        position: absolute;
        top: 100%;
        left: 0;
        color: red;
        font-size: 12px;
        margin-bottom: 0;
        opacity: 0;
    }
    .error-message::first-letter{
        text-transform: uppercase;
    }
</style>
<div class="section-full content-inner contact-style-1 bg-gray" id="contact_us">
    <div class="container">
        <div class="row">
            <!-- Left part start -->
            <div class="col-lg-8">
                <div class="p-a30 bg-gray clearfix m-b30 ">
                    <h2>@lang('Send Message Us')</h2>
                    <div class="dz-FormMsg">
                        <div class="gen alert alert-success" style="display:none;"></div>
                    </div>
                    <form method="post" id="contact-form">
                        <input type="hidden" value="Contact" name="dzToDo">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <div class="input-group">
                                        <input name="name" type="text"  class="form-control" placeholder="{{ __('Your Name') }}">
                                        <p class="error-message">@lang('Error message')</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <div class="input-group">
                                        <input name="phone" type="text"  class="form-control" placeholder="{{ __('Phone') }}">
                                        <p class="error-message">@lang('Error message')</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <div class="input-group">
                                        <input name="email" type="email" class="form-control"  placeholder="{{ __('Your Email') }}">
                                        <p class="error-message">@lang('Error message')</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <div class="input-group">
                                        <textarea name="message" rows="4" class="form-control"  placeholder="{{ __('Your Message...') }}"></textarea>
                                        <p class="error-message">@lang('Error message')</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <button name="submit" type="submit" value="Submit" class="site-button ">
                                    <span>@lang('Submit')</span> </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Left part END -->
            <!-- right part start -->
            <div class="col-lg-4 d-lg-flex">
                <div class="p-a30 m-b30 border-1 contact-area align-self-stretch">
                    <h2 class="m-b10">@lang('Quick Contact')</h2>
                    <p>@lang('If you have any questions simply use the following contact details.')</p>
                    <ul class="no-margin">
                        <li class="icon-bx-wraper left m-b30">
                            <div class="icon-bx-xs bg-primary"> <a href="#" class="icon-cell"><i
                                        class="ti-location-pin"></i></a> </div>
                            <div class="icon-content">
                                <h6 class="text-uppercase m-tb0 dlab-tilte">@lang('Address')</h6>
                                <p>{{ Settings::get('address') }}</p>
                            </div>
                        </li>
                        <li class="icon-bx-wraper left  m-b30">
                            <div class="icon-bx-xs bg-primary"> <a href="#" class="icon-cell"><i
                                        class="ti-email"></i></a> </div>
                            <div class="icon-content">
                                <h6 class="text-uppercase m-tb0 dlab-tilte">@lang('Email')</h6>
                                <p>{{ Settings::get('email') }}</p>
                            </div>
                        </li>
                        <li class="icon-bx-wraper left">
                            <div class="icon-bx-xs bg-primary"> <a href="#" class="icon-cell"><i
                                        class="ti-mobile"></i></a> </div>
                            <div class="icon-content">
                                <h6 class="text-uppercase m-tb0 dlab-tilte">@lang('PHONE')</h6>
                                <p>{{ Settings::get('phone') }}</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- right part END -->
        </div>
    </div>
</div>

<script>
    const form = document.getElementById('contact-form'); // Replace with your form's ID

    function validateInput(inputs) {
        inputs.forEach(input => {
            if (input && input.value == '') {
                input.nextElementSibling.innerText = input?.name + ' field is required';
                input.nextElementSibling.style.opacity = '1';
                hasError = true;

                alertMessage.text('All field is required ...').addClass('alert-danger');

            }else {
                input.nextElementSibling.innerText = ''
                input.nextElementSibling.style.opacity = '0'
            };
        })
    }

    form.addEventListener('submit', async function (event) {
        event.preventDefault();

        alertMessage = $('.dz-FormMsg .alert').removeClass('alert-danger');

        alertMessage.text('Submiting ...').show(1000);

        // Extract form data
        const name = this.querySelector('[name=name]');
        const email = this.querySelector('[name=email]');
        const phone = this.querySelector('[name=phone]');
        const message = this.querySelector('[name=message]');
        // const recaptcha = this.querySelector('[name=g-recaptcha-response]');

        // Prepare data payload based on API requirements
        const data = {
            name: name.value,
            email: email.value,
            phone: phone.value,
            message: message.value,
            // "g-recaptcha-response": recaptcha.value,
        };

        hasError = false;
        validateInput([name,email,phone,message])
        if (hasError) return;

        // Make the API request
        const baseUrl = window.location.origin;
        const response = await fetch(`${baseUrl}/send/contact/message`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            body: JSON.stringify(data)
        });

        if (!response?.ok) {
            alertMessage.text('Not sent message '+response?.message).addClass('alert-danger');
        }else{
            alertMessage.text('Message sent successfully').removeClass('alert-danger');
            name.value =''
            phone.value =''
            email.value =''
            message.value =''
            // recaptcha.value =''
            let dd = setInterval(() => {
                alertMessage.hide(1000)
                clearInterval(dd)
            }, 5000);
        }

    });
</script>

