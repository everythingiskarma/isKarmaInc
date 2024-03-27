  function isPhone() {
    return /Android|webOS|iPhone|iPad|iPod|Blackberry|IEMobile|Opera Mini/i.test(navigator.userAgent);
  }
  function loadMobileCSS() {
    if(isPhone()) {
      var cssLink = document.createElement("link");
      cssLink.href = domain + "/mobile.css";
      cssLink.rel = "stylesheet";
      cssLink.type = "text/css";
      document.head.appendChild(cssLink);
    }
  }
  // load mobile css
  loadMobileCSS();
