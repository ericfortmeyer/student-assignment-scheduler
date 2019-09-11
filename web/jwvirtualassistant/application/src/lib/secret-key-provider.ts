import { Injectable } from '@angular/core';
import { SecretKey } from 'src/app/secret-key';
import { environment } from 'src/environments/environment';

@Injectable({
    providedIn: 'root'
})

/*
A utility for retrieving the secret key

There are various options for storing and retrieving the CryptoKey.
It can be imported from various locations in various formats, or the object can be stored in IndexDB for example.
*/
export class SecretKeyProvider {
    private readonly signingAlgorithm = 'HMAC';
    private readonly secretKeyFormat = 'jwk';
    private secretKey: SecretKey;
    getKey(): PromiseLike<CryptoKey> {
        this.secretKey = JSON.parse(environment.secretKey) as SecretKey;
        return crypto.subtle.importKey(
            this.secretKeyFormat,
            this.secretKey,
            this.signingAlgorithm,
            true,
            ['sign', 'verify']
        );
    }
}
