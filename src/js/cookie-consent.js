import Alpine from 'alpinejs'

/**
 * Cookie Consent Alpine.js Component
 *
 * GDPR/Garante Privacy compliant (Linee Guida 2021):
 * - Prior blocking: GA4 and third-party scripts load only after explicit consent
 * - Equal-weight Accept/Reject buttons
 * - Granular category management (Personalizza)
 * - 180-day cookie expiry (6 months per Garante)
 * - Custom events for inter-component communication (Maps click-to-load)
 *
 * GA4 Measurement ID read from data-ga4-id attribute (set by Panel field).
 */

function setCookie(name, value, days) {
  const d = new Date()
  d.setTime(d.getTime() + days * 86400000)
  document.cookie = `${name}=${value};expires=${d.toUTCString()};path=/;SameSite=Lax`
}

function getCookie(name) {
  const match = document.cookie.match(new RegExp('(^| )' + name + '=([^;]+)'))
  return match ? match[2] : null
}

Alpine.data('cookieConsent', () => ({
  showBanner: false,
  showCustomize: false,
  analyticsEnabled: false,
  thirdpartyEnabled: false,

  init() {
    const consent = getCookie('cookie_consent')
    if (!consent) {
      this.showBanner = true
    } else {
      const prefs = this._parseConsent(consent)
      this.analyticsEnabled = prefs.analytics
      this.thirdpartyEnabled = prefs.thirdparty
      if (prefs.analytics) this._loadGA4()
      if (prefs.thirdparty) document.dispatchEvent(new CustomEvent('cookie:thirdparty-accepted'))
    }
  },

  acceptAll() {
    this.analyticsEnabled = true
    this.thirdpartyEnabled = true
    this._save()
    this.showBanner = false
    this._loadGA4()
    document.dispatchEvent(new CustomEvent('cookie:thirdparty-accepted'))
  },

  rejectAll() {
    this.analyticsEnabled = false
    this.thirdpartyEnabled = false
    setCookie('cookie_consent', 'analytics:0|thirdparty:0', 180)
    this.showBanner = false
    document.dispatchEvent(new CustomEvent('cookie:thirdparty-refused'))
  },

  savePreferences() {
    this._save()
    this.showBanner = false
    this.showCustomize = false
    if (this.analyticsEnabled) this._loadGA4()
    if (this.thirdpartyEnabled) {
      document.dispatchEvent(new CustomEvent('cookie:thirdparty-accepted'))
    } else {
      document.dispatchEvent(new CustomEvent('cookie:thirdparty-refused'))
    }
  },

  reopenBanner() {
    this.showBanner = true
    this.showCustomize = true
  },

  _save() {
    const v = `analytics:${this.analyticsEnabled ? 1 : 0}|thirdparty:${this.thirdpartyEnabled ? 1 : 0}`
    setCookie('cookie_consent', v, 180)
  },

  _parseConsent(str) {
    const out = { analytics: false, thirdparty: false }
    str.split('|').forEach((part) => {
      const [key, val] = part.split(':')
      if (key === 'analytics') out.analytics = val === '1'
      if (key === 'thirdparty') out.thirdparty = val === '1'
    })
    return out
  },

  _loadGA4() {
    if (window._ga4Loaded) return
    const ga4Id = this.$el.dataset.ga4Id
    if (!ga4Id) return
    window._ga4Loaded = true
    const s = document.createElement('script')
    s.src = `https://www.googletagmanager.com/gtag/js?id=${ga4Id}`
    s.async = true
    document.head.appendChild(s)
    window.dataLayer = window.dataLayer || []
    function gtag() { window.dataLayer.push(arguments) }
    gtag('js', new Date())
    gtag('config', ga4Id)
  },
}))

// Export getCookieConsent for use in inline scripts (Maps click-to-load)
window.getCookieConsent = function (category) {
  const consent = getCookie('cookie_consent')
  if (!consent) return false
  const match = consent.match(new RegExp(category + ':(\\d)'))
  return match ? match[1] === '1' : false
}
