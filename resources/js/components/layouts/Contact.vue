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
                    v-model="formData.fullName"
                    autocomplete="off"
                ></b-form-input>
                <b-form-invalid-feedback :state="!(formValidation.errForm.hasOwnProperty('fullName') && formValidation.errForm.fullName.includes('required'))">
                    *This field is required
                </b-form-invalid-feedback>
            </div>

            <div class="form-group">
                <label for="email" class="d-block"> Email <span class="req">*</span></label>
                <b-form-input
                    id="email"
                    v-model="formData.email"
                    autocomplete="off"
                ></b-form-input>
                <b-form-invalid-feedback :state="!(formValidation.errForm.hasOwnProperty('email') && formValidation.errForm.email.includes('email'))">
                    Email not valid
                </b-form-invalid-feedback>
                <b-form-invalid-feedback :state="!(formValidation.errForm.hasOwnProperty('email') && formValidation.errForm.email.includes('required'))">
                    *This field is required
                </b-form-invalid-feedback>
            </div>

            <div class="form-group">
                <label for="mobile_number" class="d-block"> Mobile Number <span class="req">*</span></label>
                <b-form-input
                    autocomplete="off"
                    v-model="formData.phoneNumber"
                    id="mobile_number"
                ></b-form-input>
                <b-form-invalid-feedback :state="!(formValidation.errForm.hasOwnProperty('phoneNumber') && formValidation.errForm.phoneNumber.includes('required'))">
                    *This field is required
                </b-form-invalid-feedback>
                <b-form-invalid-feedback :state="!(formValidation.errForm.hasOwnProperty('phoneNumber') && formValidation.errForm.phoneNumber.includes('phone'))">
                    Phone number not valid
                </b-form-invalid-feedback>
            </div>

            <div class="form-group">
                <label for="message" class="d-block"> Message <span class="req">*</span></label>
                <b-form-textarea
                    v-model="formData.message"
                    id="message"
                    rows="3"
                    max-rows="6"
                ></b-form-textarea>
                <b-form-invalid-feedback :state="!(formValidation.errForm.hasOwnProperty('message') && formValidation.errForm.message.includes('required'))">
                    *This field is required
                </b-form-invalid-feedback>
            </div>

            <div class="form-group">
                <a href="javascript:void(0)" class="btn btn-blue btn-action text-white" @click="submitForm">Submit</a>
                <a href="javascript:void(0)" class="btn btn-white btn-action" @click="resetForm">Clear</a>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios'
export default {
    data() {
        return {
            formData: {
                fullName: '',
                email: '',
                phoneNumber: '',
                message: '',
            },
            formValidation: {
                model: {
                    fullName: ['required'],
                    email: ['required', 'email'],
                    phoneNumber: ['required','phone'],
                    message: ['required'],
                },
                errForm: {}
            }
        }
    },

    methods: {
        resetForm: function() {
            let self = this
            Object.keys(self.formData).forEach((item, i) => {
                self.formData[item] = ''
            })
        },

        submitForm: async function() {
            let self = this
            await this.validateForm()
            if(Object.keys(self.formValidation.errForm).length) return
             axios({
                method: 'post',
                url: '/api/v1/send-email',
                data: self.formData
            }).then((res) => {
                let data = res.data
                if(data.status) {
                    self.bannersImg = data.values.banner
                }
            })
        },

        validateForm: function() {
            let self = this
            let errForm = {}
            let formValidationModel = self.formValidation.model
            for(var key in self.formData) {
                const modelValidation = formValidationModel[key]
                let arrError = [];
                for (let idx in modelValidation) {
                    const validation = modelValidation[idx];
                    console.log(validation, self.formData[key])
                    
                    if(validation == 'required') {
                        if(self.isBlank(self.formData[key])) {
                            arrError.push(validation)
                            break;
                        }
                    }

                    if(validation == 'phone') {
                        if(!self.validatePhone(self.formData[key])) {
                            arrError.push(validation)
                            break;
                        }
                    }

                    if(validation == 'email') {
                        if(!self.validateEmail(self.formData[key])) {
                            arrError.push(validation)
                            break;
                        }
                    }
                }
                if(arrError.length > 0) errForm[key] = arrError
            }
            self.formValidation.errForm = errForm
        }
    }

}
</script>

<style>

</style>