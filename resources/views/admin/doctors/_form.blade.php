@php $doctor = $doctor ?? null; @endphp

<div class="form-group">
    <label for="name">Full Name</label>
    <input type="text" id="name" name="name" value="{{ old('name', $doctor->name ?? '') }}" required>
    @error('name') <div class="field-error">{{ $message }}</div> @enderror
</div>

<div class="form-group">
    <label for="specialty">Specialty</label>
    <input type="text" id="specialty" name="specialty" value="{{ old('specialty', $doctor->specialty ?? '') }}" placeholder="e.g. Cardiology">
    @error('specialty') <div class="field-error">{{ $message }}</div> @enderror
</div>

<div class="form-group">
    <label for="email">Email</label>
    <input type="email" id="email" name="email" value="{{ old('email', $doctor->email ?? '') }}">
    @error('email') <div class="field-error">{{ $message }}</div> @enderror
</div>

<div class="form-group">
    <label for="phone">Phone</label>
    <input type="text" id="phone" name="phone" value="{{ old('phone', $doctor->phone ?? '') }}">
    @error('phone') <div class="field-error">{{ $message }}</div> @enderror
</div>

<div class="form-group">
    <label for="address">Address</label>
    <textarea id="address" name="address" rows="3">{{ old('address', $doctor->address ?? '') }}</textarea>
    @error('address') <div class="field-error">{{ $message }}</div> @enderror
</div>

<div class="form-group">
    <label for="login_password">Doctor Portal Password</label>
    <input type="password" id="login_password" name="login_password" placeholder="{{ $doctor && $doctor->user_id ? 'Leave blank to keep current password' : 'Set a password to enable doctor login' }}">
    <small>Requires the email above. Doctor logs in at /login with this email and password to see their patients and appointments.</small>
    @error('login_password') <div class="field-error">{{ $message }}</div> @enderror
</div>
