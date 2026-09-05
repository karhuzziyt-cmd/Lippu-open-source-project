async function detectAdBlock() {
    localStorage.setItem('adblock', false);
    let adBlockEnabled = false
    const googleAdUrl = 'https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js'
    try {
      await fetch(new Request(googleAdUrl)).catch(_ => adBlockEnabled = true)
    } catch (e) {
      adBlockEnabled = true
    } finally {
      localStorage.setItem('adblock', adBlockEnabled);
    }
  }
  detectAdBlock()
