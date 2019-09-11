import { Injectable } from '@angular/core';
import { HttpInterceptor, HttpRequest, HttpHandler, HttpEvent, HttpResponse } from '@angular/common/http';
import { AuthorizationTokenService } from '../authorization-token.service';
import { Observable, from, EMPTY } from 'rxjs';
import { OauthToken } from 'src/app/oauth-token';
import { map, tap, concatMap, catchError, mergeMap } from 'rxjs/operators';
import { RefreshTokenService } from '../refresh-token.service';
import { OauthRefreshToken } from 'src/app/oauth-refresh-token';
import { MaybeOauthToken } from 'src/app/maybe-oauth-token';

@Injectable()

export class ResourceRequestInterceptor implements HttpInterceptor {
  constructor(private refreshTokenService: RefreshTokenService, private authService: AuthorizationTokenService) {}
  intercept(req: HttpRequest<any>, next: HttpHandler): Observable<HttpEvent<any>> {
    const one = 1;
    return from(this.authService.getToken())
      .pipe(
        concatMap(
          (maybeToken: MaybeOauthToken) => {
            if (maybeToken.isValid) {
              const OAUTH_TOKEN = maybeToken as OauthToken;
              const access_token = OAUTH_TOKEN.access_token;
              const token_type = OAUTH_TOKEN.token_type;
              const authReq = req.clone({
              headers: req.headers
                  .set('Authorization', `${token_type} ${access_token}`)
                  .append('Content-Type', 'application/json')
              });
              return next.handle(authReq).pipe(
                catchError((error, s) => {
                  if (error.status === 401) {
  
                    return from(this.refreshTokenService.refreshToken(OAUTH_TOKEN.refresh_token)).pipe(
                      catchError((error, s) => {
                          if (error.status === 400) {
                            const one = 1;
                            //there's a problem with the request (i.e. invalid refresh token)
                            //redirect to logout page
                          }
                          const newRefreshToken = 'fd02d945eeb2afaf741f6e49cd53c1c6e289a08d' as OauthRefreshToken;
                          return this.refreshTokenService.refreshToken(newRefreshToken).pipe(
                            catchError((error, s) => {
                              const one = 1;
                              return s;
                            })
                          );
                        }
                      ),
                      tap(
                        (OAUTH_TOKEN: OauthToken) => {
                          console.log(OAUTH_TOKEN);
                          this.authService.storeToken(OAUTH_TOKEN);
                        }
                      ),
                      concatMap(
                        (refreshedAccessToken: OauthToken) => {
                          const authReqWithRefreshedToken = authReq.clone({
                            headers: req.headers.set('Authorization', `${token_type} ${refreshedAccessToken}`)
                          });
                          const one = 1;
                          return next.handle(authReqWithRefreshedToken).pipe(
                            catchError((error, _s) => {
                              if (error.status === 400) {
                                throw 'bad request';
                              }
                              return EMPTY;
                            })
                          );
                        }
                      ),
                    )
                  }
                  return s;
                })
              );
            }
        }
      )
    );
  }
}
