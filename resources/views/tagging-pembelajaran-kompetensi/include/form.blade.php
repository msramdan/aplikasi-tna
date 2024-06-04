<div class="row mb-2">
<div class="col-md-6 mb-2">
                               <label for="topik-id">{{ __('Topik') }}</label>
                                    <select class="form-control @error('topik_id') is-invalid @enderror" name="topik_id" id="topik-id"  required>
                                        <option value="" selected disabled>-- {{ __('Select topik') }} --</option>
                                        
                        @foreach ($topiks as $topik)
                            <option value="{{ $topik->id }}" {{ isset($taggingPembelajaranKompetensi) && $taggingPembelajaranKompetensi->topik_id == $topik->id ? 'selected' : (old('topik_id') == $topik->id ? 'selected' : '') }}>
                                {{ $topik->id }}
                            </option>
                        @endforeach
                                    </select>
                                    @error('topik_id')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
</div>

<div class="col-md-6 mb-2">
                               <label for="kompetensi-id">{{ __('Kompetensi') }}</label>
                                    <select class="form-control @error('kompetensi_id') is-invalid @enderror" name="kompetensi_id" id="kompetensi-id"  required>
                                        <option value="" selected disabled>-- {{ __('Select kompetensi') }} --</option>
                                        
                        @foreach ($kompetensis as $kompetensi)
                            <option value="{{ $kompetensi->id }}" {{ isset($taggingPembelajaranKompetensi) && $taggingPembelajaranKompetensi->kompetensi_id == $kompetensi->id ? 'selected' : (old('kompetensi_id') == $kompetensi->id ? 'selected' : '') }}>
                                {{ $kompetensi->id }}
                            </option>
                        @endforeach
                                    </select>
                                    @error('kompetensi_id')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
</div>

</div>