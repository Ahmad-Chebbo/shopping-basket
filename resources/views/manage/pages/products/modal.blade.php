<!-- Modal -->
<div id="product_modal" class="modal fade" role="dialog" tabindex="-1" aria-modal="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h2>{{ __('Product Form') }}</h2>
                <button type="button" aria-label="Close" class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                    <span class="svg-icon svg-icon-1">
						<svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
							<g transform="translate(12.000000, 12.000000) rotate(-45.000000) translate(-12.000000, -12.000000) translate(4.000000, 4.000000)" fill="#000000">
								<rect fill="#000000" x="0" y="7" width="16" height="2" rx="1"></rect>
								<rect fill="#000000" opacity="0.5" transform="translate(8.000000, 8.000000) rotate(-270.000000) translate(-8.000000, -8.000000)" x="0" y="7" width="16" height="2" rx="1"></rect>
							</g>
						</svg>
					</span>
                </button>
            </div>
            <form method="POST" action="">
                <div class="modal-body scroll-y">
                    <div class="row">
                        <!-- Form -->
                        <div class="fv-row form-group col-md-6 mb-5">
                            <label for="name" class="required form-label fs-6 fw-bolder text-gray-700 mb-3">Name</label>
                            <input type="text" id="name" class="form-control form-control-solid" name="name" placeholder="Name" required>
                        </div>

                        <div class="fv-row form-group col-md-4 mb-5">
                            <div class="row2">
                                <label for="image" class="required fs-6 fw-bolder mb-2 text-gray-700 d-block">{{ __('messages.common.image') }}</label>
                                <div class="image-input image-input-outline image-input-empty" data-kt-image-input="true" style="">
                                    <div class="image-input-wrapper w-125px h-125px bgi-position-center" id="previewImage" style="background-image: url({{ asset('manage/images/empty.jpg') }});background-size: contain;background-position: center;" ></div>
                                    <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-white shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" data-bs-dismiss="click"  title="" data-bs-original-title="Change profile">
                                        <i class="fas fa-pencil fs-7"></i>
                                        <input type="file" name="image" id="image" accept=".png, .jpg, .jpeg, .gif">
                                        <input type="hidden" name="avatar_remove" value="1">
                                    </label>
                                    <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-white shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" data-bs-dismiss="click" title="" data-bs-original-title="Cancel profile">
                                        <i class="fas fa-x fs-2"></i>
                                    </span>
                                    <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-white shadow remove-image" data-kt-image-input-action="remove" data-bs-toggle="tooltip" data-bs-dismiss="click" title="" data-bs-original-title="Remove profile">
                                        <i class="fas fa-x fs-2"></i>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="fv-row form-group col-md-4 mb-5">
                            <div class="row2">
                                <label for="image" class="fs-6 fw-bolder mb-2 text-gray-700 d-block">Cover</label>
                                <div class="image-input image-input-outline image-input-empty" data-kt-image-input="true" style="">
                                    <div class="image-input-wrapper w-125px h-125px bgi-position-center" id="previewCover" style="background-image: url({{ asset('manage/images/empty.jpg') }});background-size: contain;background-position: center;" ></div>
                                    <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-white shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" data-bs-dismiss="click"  title="" data-bs-original-title="Change profile">
                                        <i class="fas fa-pencil fs-7"></i>
                                        <input type="file" name="cover_image" id="cover_image" accept=".png, .jpg, .jpeg, .gif">
                                        <input type="hidden" name="avatar_remove" value="1">
                                    </label>
                                    <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-white shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" data-bs-dismiss="click" title="" data-bs-original-title="Cancel profile">
                                        <i class="fas fa-x fs-2"></i>
                                    </span>
                                    <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-white shadow remove-image" data-kt-image-input-action="remove" data-bs-toggle="tooltip" data-bs-dismiss="click" title="" data-bs-original-title="Remove profile">
                                        <i class="fas fa-x fs-2"></i>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="fv-row form-group col-md-12 mb-5">
                            <label for="content" class="required form-label fs-6 fw-bolder text-gray-700 mb-3">Content</label>
                            <textarea type="text" id="content" class="tinymce-editor form-control form-control-solid" name="content" placeholder="Content"></textarea>
                        </div>
                        <!-- Form -->
                    </div>
                    <div class="text-center pt-7">
                        <button type="submit" class="btn btn-primary me-2" id="btn-submit">
                            <span class="indicator-label">{{ __('messages.common.save') }}</span>
                            <span class="indicator-progress">{{ __('messages.common.please_wait') }}...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                        </button>
                        <button type="button" class="btn btn-light btn-active-light-primary me-2" data-bs-dismiss="modal">
                            {{ __('messages.common.cancel') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal -->
