<form action="/orders/contactus_save" method="post" id="form_contact_us" name="form_contact_us">
    <div id="questionBox">
        <div class="questionContent">
            <span class="interested">Quick Inquiry</span> <span class="interest-label">Each tour can be tailored.</span> 
            <div class="infoRequired">
                <p>
                    <input name="realname" id="realname" value="" placeholder="Your Name:" type="text" /> 
                </p>
                <p>
                    <input name="email" id="email" value="" placeholder="Email:" type="text" /> 
                </p>
                <p class="des">
                    <textarea name="comments" id="comments" placeholder="Tell us your tour ideas: where to visit, how many people and days..."></textarea>
                </p>
            </div>
    <input value="Send my inquiry" class="sendButton" onclick="submitForm('form_contact_us');" type="button" /> 
        </div>
    </div>
</form>