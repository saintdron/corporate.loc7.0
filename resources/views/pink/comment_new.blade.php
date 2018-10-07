<li id="li-comment-{{ $data['id'] }}" class="comment even borGreen">
    <div id="comment-{{ $data['id'] }}" class="comment-container">
        <div class="comment-author vcard">
            <img alt="{{ $data['name'] }}" src="https://www.gravatar.com/avatar/{{ $data['hash'] }}?d=mp&s=75"
                 class="avatar" height="75" width="75"/>
            <a class="fn">{{ $data['name'] }}</a>
        </div>
        <div class="comment-meta commentmetadata">
            <div class="intro">
                <div class="commentDate">
                    <span>{{ $data['date'] }}</span>
                </div>
                <div class="commentNumber">#&nbsp;</div>
            </div>
            <div class="comment-body">
                <p>{{ $data['text'] }}</p>
            </div>
        </div>
    </div>
</li>