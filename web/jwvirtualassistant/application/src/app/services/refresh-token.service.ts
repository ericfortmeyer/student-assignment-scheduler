import { Injectable } from '@angular/core';
import { HttpClient, HttpBackend } from '@angular/common/http';
import { environment } from 'src/environments/environment';
import { OauthRefreshToken } from '../oauth-refresh-token';
import { OauthToken } from '../oauth-token';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class RefreshTokenService {
  private readonly authUrl = `${environment.host}${environment.port ? `:${environment.port}` : ''}/${environment.authUrl}`;
  private readonly clientId = environment.clientId;
  private httpClient: HttpClient;
  constructor(private handler: HttpBackend) {
    this.httpClient = new HttpClient(this.handler);
   }
  refreshToken = (refreshToken: OauthRefreshToken): Observable<OauthToken> => {
    const body = {
      grant_type: 'refresh_token',
      refresh_token: refreshToken,
      client_id: this.clientId
    };
    return this.httpClient.post<OauthToken>(this.authUrl, body);
  }
}
