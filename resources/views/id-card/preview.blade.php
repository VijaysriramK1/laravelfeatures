<div 
    x-data="{
        title: $wire.entangle('data.title').live,
        applicableUser: $wire.entangle('data.applicableUser').live,
        logo: $wire.entangle('data.logo').live,
        profileImage: $wire.entangle('data.profileImage').live,
        width: $wire.entangle('data.pageLayoutWidth').live,
        height: $wire.entangle('data.pageLayoutHeight').live,
        fields: {
            admissionNo: $wire.entangle('data.admissionNo').live,
            name: $wire.entangle('data.name').live,
            class: $wire.entangle('data.class').live,
            fatherName: $wire.entangle('data.fatherName').live,
            motherName: $wire.entangle('data.motherName').live,
            address: $wire.entangle('data.address').live,
            dateOfBirth: $wire.entangle('data.dateOfBirth').live,
            bloodGroup: $wire.entangle('data.bloodGroup').live,
        }
    }"
    class="id-card-preview"
    :style="`width: ${width}mm; height: ${height}mm; border: 1px solid #ddd; padding: 10px; font-family: Arial, sans-serif;`"
>
    <!-- Logo Preview -->
    <div x-show="logo" class="logo-preview" style="text-align: center;">
        <img 
            x-bind:src="logo ? logo[0] : ''" 
            alt="Logo" 
            style="max-width: 50%; height: auto; margin-bottom: 10px;"
        >
    </div>

    <!-- ID Card Title -->
    <h2 x-text="title || 'ID Card Title'" style="text-align: center;"></h2>

    <!-- Applicable User -->
    <p>
        <strong>User Type:</strong> 
        <span x-text="applicableUser || 'Not Selected'"></span>
    </p>

    <!-- Profile Image -->
    <div x-show="profileImage" style="text-align: center;">
        <img 
            x-bind:src="profileImage ? profileImage[0] : ''" 
            alt="Profile" 
            style="width: 21mm; height: 21mm; border-radius: 50%; object-fit: cover;"
        >
    </div>

    <!-- Dynamic Fields -->
    <ul style="list-style-type: none; padding: 0; margin-top: 10px;">
        <template x-for="(value, key) in fields" :key="key">
            <li x-show="value" x-text="key + ': Enabled'" style="padding: 2px 0;"></li>
        </template>
    </ul>

    <!-- Dynamic Dimensions Display (optional) -->
    <div style="position: absolute; bottom: 5px; right: 5px; font-size: 8px;">
        <span x-text="`${width}mm x ${height}mm`"></span>
    </div>
</div>