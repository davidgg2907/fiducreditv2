import { CommonModule } from '@angular/common';
import {
  AfterViewInit,
  ChangeDetectionStrategy,
  Component,
  DestroyRef,
  ElementRef,
  EventEmitter,
  Input,
  OnChanges,
  Output,
  SimpleChanges,
  ViewChild,
  inject,
} from '@angular/core';
import { AbstractControl, FormControl, ReactiveFormsModule } from '@angular/forms';
import { takeUntilDestroyed } from '@angular/core/rxjs-interop';
import { debounceTime, distinctUntilChanged } from 'rxjs/operators';

import { MatModule } from 'src/app/appModules/mat.module';
export interface SelectOption {
  value: string | number | boolean | null;
  label: string;
}

@Component({
  selector: 'app-searchable-select',
  standalone: true,
  imports: [CommonModule, ReactiveFormsModule, MatModule],
  templateUrl:'./searchable-select.component.html',
  styleUrls:['./searchable-select.component.scss'],
  changeDetection: ChangeDetectionStrategy.OnPush
})
export class SearchableSelectComponent implements AfterViewInit, OnChanges {
  @Input({ required: true }) label: string = '';
  @Input() options: SelectOption[] = [];
  @Input() control: AbstractControl | null = null;
  @Input() remoteSearch = false;
  @Input() minSearchLength = 0;
  @Output() searchChanged = new EventEmitter<string>();
  @Output() selectionChanged = new EventEmitter<unknown>();

  @ViewChild('searchInput') private searchInput?: ElementRef<HTMLInputElement>;

  private readonly destroyRef = inject(DestroyRef);
  private readonly fallbackControl = new FormControl<unknown>(null);
  readonly searchControl = new FormControl('');
  filteredOptions: SelectOption[] = [];

  get boundControl(): FormControl<unknown> {
    return this.control instanceof FormControl ? this.control : this.fallbackControl;
  }

  ngAfterViewInit(): void {
    this.searchControl.valueChanges
      .pipe(takeUntilDestroyed(this.destroyRef))
      .pipe(debounceTime(this.remoteSearch ? 300 : 0), distinctUntilChanged())
      .subscribe((value) => {
        if (this.remoteSearch) {
          this.emitRemoteSearch(value ?? '');
          return;
        }

        this.applyFilter(value ?? '');
      });
  }

  ngOnChanges(changes: SimpleChanges): void {
    if (changes['options']) {
      if (this.remoteSearch) {
        this.filteredOptions = [...this.options];
        return;
      }

      this.applyFilter(this.searchControl.value ?? '');
    }
  }

  onOpenedChange(opened: boolean): void {
    if (!opened) {
      this.searchControl.setValue('', { emitEvent: true });
      return;
    }

    queueMicrotask(() => {
      this.searchInput?.nativeElement.focus();
    });
  }

  onSelectionChanged(value: unknown): void { this.selectionChanged.emit(value); }

  trackByValue(index: number, option: SelectOption): string {
    return `${typeof option.value}:${String(option.value)}`;
  }

  private applyFilter(rawValue: string): void {
    const search = rawValue.toLowerCase().trim();

    if (!search) {
      this.filteredOptions = [...this.options];
      return;
    }

    this.filteredOptions = this.options.filter((option) =>
      option.label.toLowerCase().includes(search) ||
      String(option.value ?? '').toLowerCase().includes(search)
    );
  }

  private emitRemoteSearch(rawValue: string): void {
    const search = rawValue.trim();

    if (search.length < this.minSearchLength) {
      this.filteredOptions = [...this.options];
      this.searchChanged.emit('');
      return;
    }

    this.searchChanged.emit(search);
  }
}
