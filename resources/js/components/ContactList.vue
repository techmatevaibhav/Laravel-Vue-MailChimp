<template>
  <div>
    <h1>MailChimp Contacts Info</h1>
    <div class="row">
      <div class="col-md-10"></div>
      <div class="col-md-2">
        <router-link :to="{ name: 'create' }" class="btn btn-primary"
          >Create Contact</router-link
        >
      </div>
    </div>
    <br />
    <section v-if="errored">
      <p>
        We're sorry, we're not able to retrieve this information at the moment,
        please try back later
      </p>
    </section>
    <section v-else>
      <div v-if="loading">Loading...</div>

      <table v-else class="table table-hover">
        <thead>
          <tr>
            <th>Email</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="contact in contactLists" :key="contact.id">
            <td>{{ contact.email_address }}</td>
            <td>{{ contact.merge_fields.FNAME }}</td>
            <td>{{ contact.merge_fields.LNAME }}</td>
            <td>
              <router-link
                :to="{ name: 'edit', params: { email: contact.id } }"
                class="btn btn-primary"
                >Edit</router-link
              >
            </td>
            <td>
              <button
                class="btn btn-danger"
                v-on:click="deleteContact(contact.email_address)"
              >
                Delete
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </section>
  </div>
</template>

<script>
export default {
  data() {
    return {
      contactLists: [],
      loading: true,
      errored: false,
    };
  },
  created() {
    this.getContactList();
  },
  methods: {
    deleteContact(email) {
      let uri = `/api/contact/delete/${email}`;
      this.axios.delete(uri).then((response) => {
        console.log(this.contactLists);
        this.getContactList();
      });
    },
    getContactList() {
      let uri = "/api/getConnect";
      axios
        .get(uri)
        .then((response) => {
          this.contactLists = response.data;
        })
        .catch((error) => {
          console.log(error);
          this.errored = true;
        })
        .finally(() => (this.loading = false));
    },
  },
};
</script>
