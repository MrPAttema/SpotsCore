'use strict';

const applicationServerPublicKey = 'BJ5YY6d8eFmyurNidZm1ALMbtv_b7sIWT9Lt1KZH6jXThmwQAdzehSb_ZjqIDBWDBPIucHsG18b_SrKJz_177sA';

const pushButton = document.querySelector('.push-subscription-button');

let isSubscribed = false;
let swRegistration = null;

function urlB64ToUint8Array(base64String) {
    const padding = '='.repeat((4 - base64String.length % 4) % 4);
    const base64 = (base64String + padding)
        .replace(/\-/g, '+')
        .replace(/_/g, '/');

    const rawData = window.atob(base64);
    const outputArray = new Uint8Array(rawData.length);

    for (let i = 0; i < rawData.length; ++i) {
        outputArray[i] = rawData.charCodeAt(i);
    }
    return outputArray;
}

function updateBtn() {
    if (Notification.permission === 'denied') {
        pushButton.textContent = 'Push Messaging Blocked.';
        pushButton.disabled = true;
        updateSubscriptionOnServer(null);
        return;
    }

    if (isSubscribed) {
        pushButton.textContent = 'Push notificaties uitschakelen';
    } else {
        pushButton.textContent = 'Push notificaties inschakelen';
    }

    pushButton.disabled = false;
}

function updateSubscriptionOnServer(subscription) {

    const subscriptionJson = document.querySelector('.js-subscription-json');
    const subscriptionDetails =
        document.querySelector('.js-subscription-details');

    if (subscription) {
        return push_sendSubscriptionToServer(subscription, 'POST');
    } else {
        console.log('Error: Subscription not send.')
    }
}

function push_sendSubscriptionToServer(subscription, method) {
    const key = subscription.getKey('p256dh');
    const token = subscription.getKey('auth');
    const encoding = (PushManager.supportedContentEncodings || ['aesgcm'])[0];

    return fetch('https://api.patrickattema.nl/v3/push/subscription', {
        method,
        body: JSON.stringify({
            endpoint: subscription.endpoint,
            publicKey: key ? btoa(String.fromCharCode.apply(null, new Uint8Array(key))) : null,
            authToken: token ? btoa(String.fromCharCode.apply(null, new Uint8Array(token))) : null,
            encoding,
        }),
    })
}

function subscribeUser() {
    const applicationServerKey = urlB64ToUint8Array(applicationServerPublicKey);
    swRegistration.pushManager.subscribe({
        userVisibleOnly: true,
        applicationServerKey: applicationServerKey
    })
        .then(function (subscription) {
            console.log('User is subscribed.');

            updateSubscriptionOnServer(subscription);

            isSubscribed = true;

            updateBtn();
        })
        .catch(function (err) {
            console.log('Failed to subscribe the user: ', err);
            updateBtn();
        });
}

function unsubscribeUser() {
    swRegistration.pushManager.getSubscription()
    .then(function (subscription) {
        if (subscription) {
            return push_sendSubscriptionToServer(subscription, 'DELETE');
            return subscription.unsubscribe();
        }
    })
    .catch(function (error) {
        console.log('Error unsubscribing', error);
    })
    .then(function () {
        console.log('User is unsubscribed.');
        isSubscribed = false;

        updateBtn();
    });
}

function initializeUI() {
    pushButton.addEventListener('click', function () {
        pushButton.disabled = true;
        if (isSubscribed) {
            unsubscribeUser();
        } else {
            subscribeUser();
        }
    });

    swRegistration.pushManager.getSubscription()
    .then(function (subscription) {
        isSubscribed = !(subscription === null);

        updateSubscriptionOnServer(subscription);

        if (isSubscribed) {
            console.log('User is subscribed.');
        } else {
            console.log('User is NOT subscribed.');
        }

        updateBtn();
    });
}

if ('serviceWorker' in navigator && 'PushManager' in window) {
    console.log('Service Worker and Push is supported');

    navigator.serviceWorker.register('../js/serviceWorker.js')
        .then(function (swReg) {
            console.log('Service Worker is registered', swReg);

            swRegistration = swReg;
            initializeUI();
        })
        .catch(function (error) {
            console.error('Service Worker Error', error);
        });
} else {
    console.warn('Push messaging is not supported');
    pushButton.textContent = 'Push niet ondersteund';
}