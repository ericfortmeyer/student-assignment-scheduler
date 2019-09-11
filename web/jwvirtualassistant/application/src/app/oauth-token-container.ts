import { OauthTokenTimestamp } from './oauth-token-timestamp';
import { OauthToken } from './oauth-token';

export class OauthTokenContainer {
    JWT: OauthToken;
    exp: OauthTokenTimestamp;
}
