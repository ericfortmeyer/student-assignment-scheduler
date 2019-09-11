import { ErrorStateMatcher } from '@angular/material/core';
import { FormControl, FormGroupDirective, NgForm } from '@angular/forms';

export class CustomErrorStateMatcher implements ErrorStateMatcher {
    isErrorState(control: FormControl | null): boolean {
        return !!(control && control.invalid && (control.dirty || control.touched));
    }
}
