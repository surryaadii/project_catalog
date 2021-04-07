<template>
    <div class="container contact-us-page">
        <div class="contact-us-title">
            <h1>Hotline Services</h1>
            <span>We are always interested in what’s on your mind. <br/>Please do not hesitate to get in touch with us regarding your need.</span>
        </div>
        <div class="contact-us-address">
            <p>
                <span> Global Business Solution Pte</span> 
                    <br /> 
                    Ltd 8, Marina Boulevard Level 11, Tower 1
                    <br /> 
                    Marina Bay Financial Centre, S 
                    <br />
                    Tel : +65 66534778 
                    <br />
                    Fax : +65 66534788
            </p>
            <p>
                or send us an email below, we will reply your email as soon as possible.
            </p>
        </div>
        <div class="contact-us-form">
            <div class="form-group">
                <label for="name" class="d-block"> Full Name <span class="req">*</span></label>
                <b-form-input
                    id="name"
                    autocomplete="off"
                ></b-form-input>
                <b-form-invalid-feedback :state="false">
                    *This field is required
                </b-form-invalid-feedback>
            </div>

            <div class="form-group">
                <label for="email" class="d-block"> Email <span class="req">*</span></label>
                <b-form-input
                    id="email"
                    autocomplete="off"
                ></b-form-input>
            </div>

            <div class="form-group">
                <label for="mobile_number" class="d-block"> Mobile Number <span class="req">*</span></label>
                <b-form-input
                    autocomplete="off"
                    id="mobile_number"
                ></b-form-input>
            </div>

            <div class="form-group">
                <label for="message" class="d-block"> Message <span class="req">*</span></label>
                <b-form-textarea
                    id="message"
                    rows="3"
                    max-rows="6"
                ></b-form-textarea>
            </div>

            <div class="form-group">
                <a href="javascript:void(0)" class="btn btn-blue btn-action text-white">Submit</a>
                <a href="javascript:void(0)" class="btn btn-white btn-action">Clear</a>
            </div>
        </div>
    </div>
</template>

<script>
export default {

}
</script>

<style>

</style>