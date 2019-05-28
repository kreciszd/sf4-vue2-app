export default {
  methods: {
    getPageParameters (url) {
      const uri = url.split('?')
      const getVars = {}

      if (uri.length === 2) {
        const vars = uri[1].split('&')
        let tmp = ''
        vars.forEach((v) => {
          tmp = v.split('=')
          if (tmp.length === 2) getVars[tmp[0]] = tmp[1]
        })
      }

      return Number(getVars.page)
    },
    buildQueryString (query) {
      return Object.keys(query)
        .map(k => (k) + '=' + (query[k]))
        .join('&')
    }
  }
}
