### Php Sdk for Pocketbase

#### Crud adapted from js-sdk to php

```
// Returns a paginated records list.
🔓 pb.collection(collectionIdOrName).getList(int $page = 1, int $perPage = 30, array $queryParams = []);

// Returns a list with all records batch fetched at once.
🔓 pb.collection(collectionIdOrName).getFullList(int $batch = 200, array $queryParams = []);

// Returns the first found record matching the specified filter.
🔓 pb.collection(collectionIdOrName).getFirstListItem(string $filter, array $queryParams = []);

// Returns a single record by its id.
🔓 pb.collection(collectionIdOrName).getOne(string $recordId, array $queryParams = []);

// Creates (aka. register) a new record.
🔓 pb.collection(collectionIdOrName).create(array  $bodyParams = [], array $queryParams = []);

// Updates an existing record by its id.
🔓 pb.collection(collectionIdOrName).update(string $recordId, array $bodyParams = [],array $queryParams = []);

// Deletes a single record by its id.
🔓 pb.collection(collectionIdOrName).delete(string $recordId, array $queryParams = []);
```