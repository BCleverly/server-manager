import {
    browserSupportsWebAuthn,
    startAuthentication,
    startRegistration,
} from '@simplewebauthn/browser'

window.browserSupportsWebAuthn = browserSupportsWebAuthn;
window.startAuthentication = startAuthentication;
window.startRegistration = startRegistration;
/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allow your team to quickly build robust real-time web applications.
 */

import './echo';
