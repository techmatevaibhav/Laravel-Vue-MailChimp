<template>
  <div>

    <h1>Create MailChimp Contact</h1>
    <form method="post" @submit.prevent="addContact" novalidate="true">

      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label for="firstName">First Name:</label>
            <input
              type="text"
              class="form-control"
              placeholder="First Name"
              id="firstName"
              name="firstName"
              v-model="contact.firstName"
            />
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
             <label for="lastName">Last Name:</label>
            <input
              type="text"
              class="form-control"
              placeholder="Last Name"
              id="lastName"
              name="lastName"
              v-model="contact.lastName"
            />
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label for="email">Email:</label>
            <input
              type="text"
              class="form-control"
              placeholder="Your email eddress"
              id="email"
              name="email"
              v-model="contact.email"
            />
          </div>
        </div>
      </div>

      <br />
      <div class="form-group">
        <button class="btn btn-primary">Create</button>
      </div>
    </form>
  </div>
</template>

<script>
export default {
  data() {
    return {
      contact: {},
       errors: [],
      firstName: null,
      lastName: null,
      email: null,
    };
  },
  methods: {
    addContact() {
      let uri = "/api/contact/create";
      this.axios.post(uri, this.contact).then((response) => {

        console.log('status: ', response.status);
        alert('contact created successfully!')
        this.$router.push({ name: "contacts" });
      }).catch(error => {
                switch (error.response.status) {
                    case 400:
                        console.log('400 error');  // not getting here
                        break;
                    case 422:
                        alert('Email is required')
                        console.log('422 error');  // not getting here
                        break;
                    case 401:
                        console.log('401 error');  // or here
                        break;
                    case 403:
                        alert('Email address already exist')
                        console.log('Email address already exist');  // or here
                        break;
                    default:
                        console.log('some other error');  // end up here all the time
                        break;
                    }

            console.log('Error: ', error);
        });
    }

  },
};
</script>
