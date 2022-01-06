# Install

```bash
npm install casteaching
```

# Usage

```javascript
import casteaching from 'casteaching'

// Obtain published video list
casteaching.videos()

// Obtain video by id
casteaching.video.show(1)

// Create Video
casteaching.video.create({name: 'PHP 101', description: 'Bla bla bla',  url: 'https://youtube.com/...' })

// Update Video
casteaching.video.update(1,{name: 'PHP 101', description: 'Bla bla bla',  url: 'https://youtube.com/...' })

// Destroy Video
casteaching.video.destroy(1)
```

# Author & Project Info

- Daniel Audí Bielsa
- Github: https://github.com/daudi44/casteaching/tree/api
