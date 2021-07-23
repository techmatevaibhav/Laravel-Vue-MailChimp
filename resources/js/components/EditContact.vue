<template>
  <div>
    <h1>Edit Contact Info</h1>

    <section v-if="errored">
      <p>
        We're sorry, we're not able to retrieve this information at the moment,
        please try back later
      </p>
    </section>

    <form @submit.prevent="updatePost">
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label>First Name:</label>

            <input
              type="text"
              class="form-control"
              v-model="contactMergeInfo.FNAME"
            />
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label>Last Name:</label>
            <input
              type="text"
              class="form-control"
              v-model="contactMergeInfo.LNAME"
            />
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label>Email:</label>
            <input
              type="text"
              class="form-control"
              v-model="contactInfo.email_address"
            />
          </div>
        </div>
      </div>

      <br />
      <div class="form-group">
        <button class="btn btn-primary">Update</button>
      </div>
    </form>
  </div>
</template>

<script>
export default {
  data() {
    return {
      contactInfo: {},
      contactMergeInfo: {},
      errored: false,
    };
  },
  created() {
    let uri = `/api/contactInfo/${this.$route.params.email}`;
    this.axios
      .get(uri)
      .then((response) => {
        if (response.data.statusCode == "subscribed") {
          const infoOfSub = response.data.data;
          this.contactInfo = infoOfSub;
          this.contactMergeInfo = infoOfSub.merge_fields;
        } else {
          this.errored = true;
        }
      })
      .catch((error) => {
        this.errored = true;
      });
  },
  methods: {
    updatePost() {
      let uri = `http://127.0.0.1:8000/api/contactInfo/update/${this.$route.params.email}`;
      const payload = {
        firstName: this.contactMergeInfo.FNAME,
        lastName: this.contactMergeInfo.LNAME,
        email: this.contactInfo.email_address,
      };
      this.axios
        .post(uri, payload)
        .then((response) => {
          this.$router.push({ name: "contacts" });
          alert('contact updated successfully!')
        })
        .catch((error) => {
           switch (error.response.status) {
                    case 400:
                        console.log('400 error');  // not getting here
                        break;
                    case 422:
                        alert('all field are required')
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
          console.log("Error: ", error);
        });
    },
  },
};
</script>
ß
