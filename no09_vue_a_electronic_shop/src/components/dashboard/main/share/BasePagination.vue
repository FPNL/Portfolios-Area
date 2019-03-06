<template>
  <nav aria-label="Page navigation example">
    <ul class="pagination justify-content-center">
      <li class="page-item" :class="{'disabled': !pagination.has_pre}">
        <a class="page-link" @click="changePagination( pagination.current_page - 1)" href="#" tabindex="-1">Previous</a>
      </li>
      <li class="page-item" :class="{'active': pagination.current_page == item}" v-for="(item, index) in pagination.total_pages" :key="index">
        <a class="page-link" @click="changePagination(item)" href="#">{{item}}</a></li>
      <li class="page-item"  :class="{'disabled': !pagination.has_next}">
        <a class="page-link" @click="changePagination( pagination.current_page + 1)"  href="#">Next</a>
      </li>
    </ul>
  </nav>
</template>

<script>
export default{
  name: 'BasePagination',
  props: {
    pagination: Object
  },
  methods: {
    changePagination (page) {
      this.$emit('pagination', Number(page))
    }
  }
}
</script>
