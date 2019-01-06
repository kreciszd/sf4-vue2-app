export default {
  methods: {
    getPageParameters(url) {
      let uri = url.split('?');
      let getVars = {};

      if (uri.length === 2) {
        let vars = uri[1].split('&');
        let tmp = '';
        vars.forEach(function (v) {
          tmp = v.split('=');
          if (tmp.length === 2) getVars[tmp[0]] = tmp[1];
        });
      }

      return Number(getVars.page);
    },
  }
}