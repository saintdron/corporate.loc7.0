<div id="content-page" class="content group">
    <div class="hentry group">
        <form id="contact-form-contact-us" class="contact-form" method="post" action="{{ route('contacts') }}" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="usermessagea"></div>
            <fieldset>
                <ul>
                    <li class="text-field">
                        <label for="name-contact-us">
                            <span class="label">Имя</span>
                            <br />					<span class="sublabel">Как вас звать-величать</span><br />
                        </label>
                        <div class="input-prepend"><span class="add-on"><i class="icon-user"></i></span><input type="text" name="name" id="name-contact-us" class="required" value="{{ old('name') }}" /></div>
                        <div class="msg-error"></div>
                    </li>
                    <li class="text-field">
                        <label for="email-contact-us">
                            <span class="label">E-mail</span>
                            <br />					<span class="sublabel">Ваша электронная почта</span><br />
                        </label>
                        <div class="input-prepend"><span class="add-on"><i class="icon-envelope"></i></span><input type="text" name="email" id="email-contact-us" class="required email-validate" value="{{ old('email') }}" /></div>
                        <div class="msg-error"></div>
                    </li>
                    <li class="textarea-field">
                        <label for="message-contact-us">
                            <span class="label">Сообщение</span>
                        </label>
                        <div class="input-prepend"><span class="add-on"><i class="icon-pencil"></i></span><textarea name="text" id="message-contact-us" rows="8" cols="30" class="required">{{ old('text') }}</textarea></div>
                        <div class="msg-error"></div>
                    </li>
                    <li class="submit-button">
                        <input type="text" name="yit_bot" id="yit_bot" />
                        <input type="hidden" name="yit_action" value="sendmail" id="yit_action" />
                        <input type="hidden" name="yit_referer" value="#" />
                        <input type="hidden" name="id_form" value="126" />
                        <input type="submit" name="yit_sendmail" value="{{ trans('custom.send_message') }}" class="sendmail alignright" />
                    </li>
                </ul>
            </fieldset>
        </form>
    </div>
</div>