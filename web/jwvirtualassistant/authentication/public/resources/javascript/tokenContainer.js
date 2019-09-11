function TokenContainer(payload) {
    this.oauth_payload = payload;
    this.exp = Date.now() / 1000 + payload.expires_in;
}
