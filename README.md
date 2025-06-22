# SoraChatGPTDownloader

A PHP class for downloading videos from ChatGPT's Sora video generation platform.

## 📋 Table of Contents

- [Features](#features)
- [Requirements](#requirements)
- [Installation](#installation)
- [Quick Start](#quick-start)
- [API Reference](#api-reference)
- [Examples](#examples)
- [Error Handling](#error-handling)
- [Contributing](#contributing)
- [License](#license)

## ✨ Features

- 🎥 Download videos from Sora ChatGPT URLs
- 🎛️ Multiple quality options (source, medium, low)
- 📊 Video metadata extraction
- 🛡️ Built-in error handling
- 🚀 Simple and lightweight
- 📱 User-agent spoofing for compatibility

## 📋 Requirements

- PHP 7.4 or higher
- cURL extension enabled
- Internet connection

## 🚀 Installation


### Option 1: Manual Installation

1. Clone the repository:
```bash
git clone https://github.com/AzozzALFiras/SoraChatGPTDownloader.git
```

2. Include the class in your project:
```php
require_once 'path/to/SoraChatGPTClass.php';
```

### Option 2: Direct Download

Download the `SoraChatGPTClass.php` file and include it in your project.

## 🎯 Quick Start

```php
<?php
require_once 'SoraChatGPTClass.php';

// Initialize with Sora URL
$sora = new SoraChatGPTClass('https://sora.chatgpt.com/g/gen_01jy8k8garfvavgrj40d62pfna');

// Get video information
$info = $sora->getVideoInfo();
print_r($info);

// Get video download URL
$videoUrl = $sora->getVideoUrl('source');
echo "Download URL: " . $videoUrl;
```

## 📚 API Reference

### Constructor

```php
__construct(string $url)
```

Initialize the class with a Sora ChatGPT URL.

**Parameters:**
- `$url` (string): The Sora video URL

**Example:**
```php
$sora = new SoraChatGPTClass('https://sora.chatgpt.com/g/gen_01jy8k8garfvavgrj40d62pfna');
```

### Methods

#### `getSoraIdFromUrl()`

Extracts the Sora ID from the provided URL.

**Returns:** `string` - The Sora ID

```php
$soraId = $sora->getSoraIdFromUrl();
// Returns: gen_01jy8k8garfvavgrj40d62pfna
```

#### `getData()`

Fetches raw data from the Sora API.

**Returns:** `array|false` - The decoded JSON response or false on failure

```php
$data = $sora->getData();
if ($data) {
    // Process the raw API data
}
```

#### `getVideoUrl($quality)`

Get the direct download URL for a specific quality.

**Parameters:**
- `$quality` (string): Quality level - `'source'`, `'md'`, or `'ld'`

**Returns:** `string|false` - Video URL or false if not found

```php
$sourceUrl = $sora->getVideoUrl('source');    // Highest quality
$mediumUrl = $sora->getVideoUrl('md');        // Medium quality  
$lowUrl = $sora->getVideoUrl('ld');           // Lowest quality
```

#### `getVideoInfo()`

Get formatted video metadata.

**Returns:** `array|false` - Video information or false on failure

```php
$info = $sora->getVideoInfo();
/*
Returns:
[
    'id' => 'gen_01jy8k8garfvavgrj40d62pfna',
    'title' => 'Floating Timeless Skies',
    'width' => 720,
    'height' => 1080,
    'duration' => 5.0,
    'created_at' => '2025-06-21T06:36:53.507275Z',
    'available_qualities' => ['source', 'md', 'ld', 'thumbnail', 'spritesheet']
]
*/
```

## 📊 API Response Structure

The Sora API returns a comprehensive JSON response with the following structure:

```json
{
    "id": "gen_01jy8k8garfvavgrj40d62pfna",
    "task_id": "task_01jy8k72axednrjcnvmkwpqp11",
    "created_at": "2025-06-21T06:36:53.507275Z",
    "deleted_at": null,
    "url": "https://videos.openai.com/vg-assets/...",
    "seed": 479835457,
    "can_download": true,
    "download_status": "ready",
    "is_public": true,
    "title": "Floating Timeless Skies",
    "width": 720,
    "height": 1080,
    "n_frames": 150,
    "encodings": {
        "source": {
            "path": "https://videos.openai.com/.../source.mp4",
            "size": 4986776,
            "width": 720,
            "height": 1080,
            "duration_secs": 5.0,
            "ssim": 0.9901485
        },
        "md": {
            "path": "https://videos.openai.com/.../md.mp4",
            "size": 852442,
            "width": 480,
            "height": 720,
            "duration_secs": 5.0,
            "ssim": 0.9681492
        },
        "ld": {
            "path": "https://videos.openai.com/.../ld.mp4",
            "size": 361690,
            "width": 480,
            "height": 720,
            "duration_secs": 5.0,
            "ssim": 0.9528452
        },
        "thumbnail": {
            "path": "https://videos.openai.com/.../thumb.webp",
            "size": null
        },
        "spritesheet": {
            "path": "https://videos.openai.com/.../sprite.jpg",
            "size": null
        }
    },
    "prompt": null,
    "actions": {
        "100": "Slowly lifts head to look up. Handheld camera, Timelapse clouds, character floating, subtle white lens flares off metal"
    },
    "operation": "storyboard",
    "model": "turbo_12",
    "user": {
        "id": "user-1mrzj8o4Q05090fpJRNq1PnW",
        "username": "manoftomorrow"
    },
    "task_type": "video_gen"
}
```

### Available Video Qualities

| Quality | Resolution | File Size | Description |
|---------|------------|-----------|-------------|
| `source` | 720×1080 | ~4.9MB | Original highest quality |
| `md` | 480×720 | ~852KB | Medium quality |
| `ld` | 480×720 | ~362KB | Low quality, smallest file |
| `thumbnail` | N/A | Small | Static preview image (WebP) |
| `spritesheet` | N/A | Small | Video preview grid (JPG) |

## 💡 Examples

### Working with Full API Response

```php
<?php
require_once 'SoraChatGPTClass.php';

$sora = new SoraChatGPTClass('https://sora.chatgpt.com/g/gen_01jy8k8garfvavgrj40d62pfna');
$data = $sora->getData();

if ($data) {
    // Access all API fields
    echo "Video ID: " . $data['id'] . "\n";
    echo "Title: " . $data['title'] . "\n";
    echo "Created: " . $data['created_at'] . "\n";
    echo "Model: " . $data['model'] . "\n";
    echo "Frames: " . $data['n_frames'] . "\n";
    echo "Can Download: " . ($data['can_download'] ? 'Yes' : 'No') . "\n";
    echo "Status: " . $data['download_status'] . "\n";
    echo "Public: " . ($data['is_public'] ? 'Yes' : 'No') . "\n";
    
    // User information
    if (isset($data['user'])) {
        echo "Creator: " . $data['user']['username'] . "\n";
        echo "User ID: " . $data['user']['id'] . "\n";
    }
    
    // Actions/prompts
    if (isset($data['actions'])) {
        echo "Actions:\n";
        foreach ($data['actions'] as $key => $action) {
            echo "  $key: $action\n";
        }
    }
    
    // Video specifications
    echo "\nVideo Details:\n";
    echo "Resolution: {$data['width']}x{$data['height']}\n";
    echo "Total Frames: {$data['n_frames']}\n";
    echo "Seed: {$data['seed']}\n";
    echo "Operation: {$data['operation']}\n";
    echo "Task Type: {$data['task_type']}\n";
}
```

```php
<?php
require_once 'SoraChatGPTClass.php';

$url = 'https://sora.chatgpt.com/g/gen_01jy8k8garfvavgrj40d62pfna';
$sora = new SoraChatGPTClass($url);

// Check if video exists
if ($sora->getData()) {
    echo "Video found!\n";
    
    // Get video info
    $info = $sora->getVideoInfo();
    echo "Title: " . $info['title'] . "\n";
    echo "Duration: " . $info['duration'] . " seconds\n";
    
    // Get download URL
    $downloadUrl = $sora->getVideoUrl('source');
    echo "Download: " . $downloadUrl . "\n";
} else {
    echo "Video not found or API error\n";
}
```

### Download Video with cURL

```php
<?php
require_once 'SoraChatGPTClass.php';

function downloadVideo($url, $filename) {
    $sora = new SoraChatGPTClass($url);
    $videoUrl = $sora->getVideoUrl('source');
    
    if (!$videoUrl) {
        echo "Failed to get video URL\n";
        return false;
    }
    
    $ch = curl_init($videoUrl);
    $fp = fopen($filename, 'w+');
    
    curl_setopt_array($ch, [
        CURLOPT_FILE => $fp,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_TIMEOUT => 300
    ]);
    
    $result = curl_exec($ch);
    fclose($fp);
    curl_close($ch);
    
    return $result;
}

// Usage
$url = 'https://sora.chatgpt.com/g/gen_01jy8k8garfvavgrj40d62pfna';
downloadVideo($url, 'video.mp4');
```

### Batch Processing

```php
<?php
require_once 'SoraChatGPTClass.php';

$urls = [
    'https://sora.chatgpt.com/g/gen_01jy8k8garfvavgrj40d62pfna',
    'https://sora.chatgpt.com/g/gen_01jy8k72axednrjcnvmkwpqp11',
    // Add more URLs...
];

foreach ($urls as $url) {
    $sora = new SoraChatGPTClass($url);
    $info = $sora->getVideoInfo();
    
    if ($info) {
        echo "Processing: " . $info['title'] . "\n";
        echo "Quality options: " . implode(', ', $info['available_qualities']) . "\n";
        echo "Download URL: " . $sora->getVideoUrl('source') . "\n\n";
    } else {
        echo "Failed to process: $url\n\n";
    }
}
```

### Quality Comparison with Real Data

```php
<?php
require_once 'SoraChatGPTClass.php';

$sora = new SoraChatGPTClass('https://sora.chatgpt.com/g/gen_01jy8k8garfvavgrj40d62pfna');
$data = $sora->getData();

if ($data && isset($data['encodings'])) {
    echo "Available video qualities for: {$data['title']}\n";
    echo str_repeat('-', 60) . "\n";
    printf("%-10s | %-12s | %-8s | %-10s | %s\n", 
           'Quality', 'Resolution', 'Duration', 'Size', 'SSIM Score');
    echo str_repeat('-', 60) . "\n";
    
    foreach (['source', 'md', 'ld'] as $quality) {
        if (isset($data['encodings'][$quality])) {
            $encoding = $data['encodings'][$quality];
            printf("%-10s | %dx%-7d | %-8.1fs | %-10s | %.4f\n",
                strtoupper($quality),
                $encoding['width'] ?? 0,
                $encoding['height'] ?? 0,
                $encoding['duration_secs'] ?? 0,
                formatBytes($encoding['size'] ?? 0),
                $encoding['ssim'] ?? 0
            );
        }
    }
    
    // Additional info
    echo "\nVideo Metadata:\n";
    echo "Total Frames: {$data['n_frames']}\n";
    echo "Model Used: {$data['model']}\n";
    echo "Created: {$data['created_at']}\n";
    echo "Creator: {$data['user']['username']}\n";
}

function formatBytes($bytes) {
    if ($bytes == 0) return '0 B';
    $units = ['B', 'KB', 'MB', 'GB'];
    $i = floor(log($bytes) / log(1024));
    return round($bytes / pow(1024, $i), 2) . ' ' . $units[$i];
}

/* Output example:
Available video qualities for: Floating Timeless Skies
------------------------------------------------------------
Quality    | Resolution   | Duration | Size       | SSIM Score
------------------------------------------------------------
SOURCE     | 720x1080     | 5.0s     | 4.75 MB    | 0.9901
MD         | 480x720      | 5.0s     | 832.46 KB  | 0.9681
LD         | 480x720      | 5.0s     | 353.21 KB  | 0.9528

Video Metadata:
Total Frames: 150
Model Used: turbo_12
Created: 2025-06-21T06:36:53.507275Z
Creator: manoftomorrow
*/
```

## 🛠️ Error Handling

The class provides several ways to handle errors:

```php
$sora = new SoraChatGPTClass($url);

// Check if API call was successful
$data = $sora->getData();
if ($data === false) {
    echo "API call failed - check URL or network connection\n";
    exit;
}

// Check if video URL exists
$videoUrl = $sora->getVideoUrl('source');
if ($videoUrl === false) {
    echo "Video URL not found - video may not exist or be private\n";
    exit;
}

// Check if video info is available
$info = $sora->getVideoInfo();
if ($info === false) {
    echo "Could not retrieve video information\n";
    exit;
}
```

## 🚨 Common Issues

### Invalid URL Format
```php
// ❌ Wrong
$sora = new SoraChatGPTClass('invalid-url');

// ✅ Correct
$sora = new SoraChatGPTClass('https://sora.chatgpt.com/g/gen_01jy8k8garfvavgrj40d62pfna');
```

### Network Timeouts
The class sets a 30-second timeout. For slow connections, you may need to modify the cURL options.

### Missing Quality
Not all videos have all quality options. Always check available qualities:
```php
$info = $sora->getVideoInfo();
if (in_array('source', $info['available_qualities'])) {
    $url = $sora->getVideoUrl('source');
}
```

## 🤝 Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## ⚠️ Disclaimer

This tool is for educational purposes only. Please respect ChatGPT's terms of service and only download videos you have permission to access.

## 🙋‍♂️ Support

If you encounter any issues or have questions:

1. Check the [Issues](https://github.com/AzozzALFiras/SoraChatGPTDownloader/issues) page
2. Create a new issue if your problem isn't already reported
3. Provide as much detail as possible including:
   - PHP version
   - Error messages
   - Sample URLs (if not sensitive)

## 🎉 Acknowledgments

- ChatGPT Sora team for the amazing video generation platform
- PHP community for excellent documentation
- Contributors who help improve this project

---

**Made with ❤️ by [AzozzALFiras](https://github.com/AzozzALFiras)**
