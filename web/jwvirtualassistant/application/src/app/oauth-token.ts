import { OauthRefreshToken } from './oauth-refresh-token';

/* tslint:disable:variable-name */
export class OauthToken {
    isValid: Boolean = true;
    access_token: string;
    refresh_token: OauthRefreshToken;
    scope: string;
    token_type: string;
    expires_in: number;
}
