<template>
  <div class="pod-records">
    <header class="header">
      <h1>Prefect of Discipline Records</h1>
      <p class="subtitle">Manage and review student discipline cases</p>
    </header>

    <section class="actions">
      <button @click="addRecord">Add Record</button>
      <input v-model="search" type="text" placeholder="Search records..." />
    </section>

    <section class="table-container">
      <table>
        <thead>
          <tr>
            <th>Student Name</th>
            <th>Grade/Section</th>
            <th>Offense</th>
            <th>Date</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(record, index) in filteredRecords" :key="index">
            <td>{{ record.name }}</td>
            <td>{{ record.section }}</td>
            <td>{{ record.offense }}</td>
            <td>{{ record.date }}</td>
            <td>{{ record.status }}</td>
          </tr>
        </tbody>
      </table>
    </section>
  </div>
</template>

<script>
export default {
  name: "PrefectDisciplineRecords",
  data() {
    return {
      search: "",
      records: [
        {
          name: "Juan Dela Cruz",
          section: "BSIT - 1A",
          offense: "Late",
          date: "2026-04-01",
          status: "Resolved",
        },
        {
          name: "Maria Santos",
          section: "BSIT - 1B",
          offense: "Uniform Violation",
          date: "2026-04-02",
          status: "Pending",
        },
      ],
    };
  },
  computed: {
    filteredRecords() {
      return this.records.filter((record) =>
        record.name.toLowerCase().includes(this.search.toLowerCase())
      );
    },
  },
  methods: {
    addRecord() {
      alert("CHUBATLA!");
    },
  },
};
</script>

<style scoped>
.pod-records {
  padding: 20px;
  font-family: Arial, sans-serif;
}

.header {
  margin-bottom: 20px;
}

.subtitle {
  color: #666;
}

.actions {
  display: flex;
  justify-content: space-between;
  margin-bottom: 15px;
}

.actions input {
  padding: 5px;
  width: 200px;
}

.actions button {
  padding: 6px 12px;
  cursor: pointer;
}

.table-container {
  overflow-x: auto;
}

table {
  width: 100%;
  border-collapse: collapse;
}

thead {
  background-color: #f4f4f4;
}

th, td {
  padding: 10px;
  border: 1px solid #ddd;
  text-align: left;
}
</style>