# FB Pixel WooTracker

FB Pixel WooTracker is a lightweight WordPress plugin that allows WooCommerce store owners to easily install their Facebook Pixel and automatically fire the "Purchase" event whenever a customer places an order. It also logs all tracked events so you can compare them with your Facebook Ads Manager.

---

## 🎯 Features

- Add your Facebook Pixel ID directly from the WordPress admin dashboard
- Automatically tracks **Purchase** events when WooCommerce orders are completed
- Stores log of each event by date for easy tracking and comparison
- No coding required — simple setup and clean UI

---

## 🛠️ Installation

1. **Upload the Plugin**

   - Download or clone this repository.
   - Upload the plugin folder to your `/wp-content/plugins/` directory, or use the **Upload Plugin** feature in WordPress Admin.

2. **Activate the Plugin**

   - Go to **Plugins > Installed Plugins** in your WordPress dashboard.
   - Find **FB Pixel WooTracker** and click **Activate**.

3. **Set Your Pixel ID**
   - Go to **Settings > FB Pixel Tracker** (added by this plugin).
   - Enter your Facebook Pixel ID.
   - Click **Save Settings**.

---

## ⚙️ How It Works

- Once installed and Pixel ID is saved, the plugin automatically inserts your Pixel into the site’s `<head>`.
- When a customer places a successful order in WooCommerce, the plugin fires the `fbq('track', 'Purchase')` event with the total value.
- All triggered events are logged with the date and time in a simple local file:  
  `wp-content/uploads/fb_pixel_woo_logs.txt`.

---

## 📁 How to View Tracked Events

To see your log of tracked purchases:

1. Connect to your site via FTP or use your cPanel File Manager.
2. Go to:  
   `wp-content/uploads/fb_pixel_woo_logs.txt`
3. Open the file to see a list of all events that were fired, including:
   - Order ID
   - Amount
   - Currency
   - Date and time

You can compare this data with the **Facebook Ads Manager** > **Events** tab to verify that the Pixel is working properly.

---

## 🤖 Requirements

- WordPress 5.0 or higher
- WooCommerce plugin installed and activated

---

## 🧑‍💻 Author

**Muhammad Asad Nazir**  
Software Developer at [GalaxyDevPK](https://galaxydev.pk)

GitHub: [github.com/galaxydevpk](https://github.com/masadnazir1)

---

## 📝 License

This plugin is licensed under the GPLv2 or later.
